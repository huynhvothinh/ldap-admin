<?php
require_once(dirname(__FILE__).'/../config.php');

class MyUser{
    public $ldap = NULL;
    public $db = NULL;
    public $user_id_key = '';

    function __construct($configs){ 
        $this->ldap = new MyLdap($configs);
        $this->user_id_key = strtolower(str_replace('=', '', $this->ldap->configs['admin_account_prefix']));
        
        $this->db = new MyDB(
            MyConfig::$db_configs['servername'],
            MyConfig::$db_configs['username'],
            MyConfig::$db_configs['password'],
            MyConfig::$db_configs['database']
        ); 
    } 

    function sort($list){
        if(is_array($list) && count($list) > 0){
            $arr = []; 
            for($index = 0; $index < count($list); $index++) {
                if(array_key_exists($index, $list)) 
                    if(array_key_exists($this->user_id_key, $list[$index]))
                        array_push($arr, $list[$index]);  
            }

            if($this->user_id_key == 'uid'){ 
                usort($arr, 'compareUserUID');
            }else{
                usort($arr, 'compareUserCN');
            }
        
            return $arr;
        }else{
            return $list;
        }
    }  

    function get_fields_list(){
        return $this->ldap->configs['fields']['user']['list'];
    }

    function get_fields_detail(){
        return $this->ldap->configs['fields']['user']['detail'];
    }

    function get_fields_edit(){
        return $this->ldap->configs['fields']['user']['edit'];
    }
    
    function get_object_dn($item){
        $arr = (array)$item;
        if($this->user_id_key == 'uid'){
            return sprintf('uid=%s,%s', $arr['uid'][0], $this->ldap->configs['base_dn']);
        }else{
            return $arr['distinguishedname'][0];
        }
    }

    function get_item($id){ 
        $filters = '(&(%s=%s)%s)'; 
        $filters = sprintf($filters, $this->user_id_key, $id, $this->ldap->configs['user_filter']); 

        $results = $this->ldap->search($filters);
        if(is_array($results) && count($results)>0)
            return $results[0];
        else
            return NULL; 
    }
    
    function get_list(){  
        $filters = $this->ldap->configs['user_filter'];
        $results = $this->ldap->search($filters); 
        if($results)
            return $this->sort($results);
        else
            return NULL; 
    } 

    function update_item($item_key, $entry){        
        return $this->ldap->update($item_key, $entry);
    }

    function sync_users(){        
        if($this->db->connect()){
            // $sql = "call basedn_list()";
            // $result = mysqli_query($this->conn, $sql);  

            // while($row = mysqli_fetch_array($result)){
            //     $default_configs['domain_controllers'] = $row['HOST'];
            //     $default_configs['base_dn'] = $row['BASEDN_CODE'];
            //     $default_configs['port'] = $row['PORT'];
            //     $default_configs['admin_account_prefix'] = $row['ACCOUNT_PREFIX'];
            //     $default_configs['admin_account_suffix'] = $row['ACCOUNT_SUFFIX'];
            //     $default_configs['admin_account_suffix_arr'] = json_decode($row['ACCOUNT_SUFFIX_ARR']);
            //     $default_configs['use_ssl'] = $row['SSL'];
            //     $default_configs['user_filter'] = $row['USER_FILTER'];
            //     $default_configs['group_filter'] = $row['GROUP_FILTER'];
            //     $default_configs['organization_filter'] = $row['ORGANIZATION_FILTER'];

            //     break;
            // } 

            $this->db->conn->close();
        }
    }
}
// 
function compareUserUID($a, $b) {
    return strcmp($a["uid"][0], $b["uid"][0]);
} 
function compareUserCN($a, $b) {
    return strcmp($a["cn"][0], $b["cn"][0]);
}  
?>