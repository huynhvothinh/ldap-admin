<?php
require_once(dirname(__FILE__).'/../config.php');

class MyLdap{
    public $ldapconn = NULL;
    public $ldapbind = NULL;
    public $configs = NULL; 

    function __construct($configs){
        $this->configs = $configs;
    }

    function connect(){
        $host = 'ldap://';
        if($this->configs['use_ssl']){
            $host = 'ldaps://';
        }
        $this->ldapconn = ldap_connect($host.$this->configs['domain_controllers'], $this->configs['port']) ;
        if($this->ldapconn) {
            ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, $this->configs['version']);
            ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
            return true;
        }
        return false;
    }
    function bind($ldaprdn=''){    
        $account = '';
        if($this->configs['admin_username']){
            $account = $this->configs['admin_account_prefix'].$this->configs['admin_username'];                
        }

        if($ldaprdn){
            $ldaprdn = $account.','.$ldaprdn.','.$this->configs['base_dn'];
        }else{
            $ldaprdn = $account.','.$this->configs['base_dn'];
        }

        $pass = $this->configs['admin_password'];   

        $this->ldapbind = @ldap_bind($this->ldapconn, $ldaprdn, $pass);

        if($this->ldapbind)
            return true;
        else
            return false;
    } 
    function auth(){   
        if($this->connect()) {  
            if ($this->bind($this->configs['admin_account_suffix'])) { 
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function search($filters){ 
        if($this->auth()) {
            $result = ldap_search($this->ldapconn,$this->configs['base_dn'], $filters);
            $data = ldap_get_entries($this->ldapconn, $result);
            return $data;
        }else{
            return NULL;
        }
    }
    function search_root($filters){ 
        if($this->auth()) {
            $result = ldap_list($this->ldapconn,$this->configs['base_dn'], $filters);
            $data = ldap_get_entries($this->ldapconn, $result);
            return $data;
        }else{
            return NULL;
        }
    }
    function update($dn, $entry){ 
        if($this->auth()) {
            try{
                $result = ldap_modify($this->ldapconn, $dn, $entry); 
                return $result;
            }catch(Exception $ex){
                return false;
            }
        }else{
            return NULL;
        }
    }
    function add_field($dn, $entry){ 
        if($this->auth()) {
            try{
                $result = ldap_mod_add($this->ldapconn, $dn, $entry); 
                return $result;
            }catch(Exception $ex){
                return false;
            }
        }else{
            return NULL;
        }
    }
    function del_field($dn, $entry){ 
        if($this->auth()) {
            try{
                $result = ldap_mod_del($this->ldapconn, $dn, $entry); 
                return $result;
            }catch(Exception $ex){
                return false;
            }
        }else{
            return NULL;
        }
    }
    function add($dn, $entry){ 
        if($this->auth()) {
            try{
                $result = ldap_add($this->ldapconn, $dn, $entry); 
                return $result;
            }catch(Exception $ex){
                return false;
            }
        }else{
            return NULL;
        }
    }
    function delete($dn){ 
        if($this->auth()) {
            try{
                $result = ldap_delete($this->ldapconn, $dn); 
                return $result;
            }catch(Exception $ex){
                return false;
            }
        }else{
            return NULL;
        }
    }
    function change_password($dn, $newPassword){
        if($this->auth()) {
            try{
                $newPassw = '';
                $newPassword = "\"" . $newPassword . "\"";
                $len = strlen($newPassword);
                for ($i = 0; $i < $len; $i++){
                    $newPassw .= "{$newPassword{$i}}\000";
                }
                $newPassword = $newPassw;

                $entry = array(); 
                $entry["unicodepwd"] = $newPassword;

                $result = ldap_mod_replace($this->ldapconn, $dn, $entry);  
                return $result;
            }catch(Exception $ex){
                return false;
            }
        }else{
            return NULL;
        }
    }
}
?>