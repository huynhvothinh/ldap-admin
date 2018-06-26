<?php
require_once(dirname(__FILE__).'/../config.php');

class MyUser{
    public $ldap = NULL; 
    public $user_id_key = '';
    public $user_object = NULL;

    function __construct($configs){ 
        $this->ldap = new MyLdap($configs);
        $this->user_id_key = strtolower(str_replace('=', '', $this->ldap->configs['admin_account_prefix'])); 
        $this->user_object = new MyObjectsDB();
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

    function get_custom_fields(){
        $fields = new MyFieldsDB();
        return $fields->get_list($this->ldap->configs['base_dn'], 'USER', 1); 
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
        if(is_array($results) && count($results)>0){
            if(!isset($results[0]['distinguishedname']) && isset($results[0]['uid'])){
                $results[0]['distinguishedname'] = [];
                array_push($results[0]['distinguishedname'], 'uid='.$results[0]['uid'][0].','.$this->ldap->configs['base_dn']);
                $results[0]['user_key'] = $results[0]['uid'][0];
            }else{
                $results[0]['user_key'] = $results[0]['cn'][0];
            }
            return $results[0];
        }else{
            return NULL; 
        }
    }
    
    function get_list(){  
        $filters = $this->ldap->configs['user_filter'];
        $results = $this->ldap->search($filters); 
        if($results){
            for($i=0;$i<count($results);$i++){
                if(!isset($results[$i]['distinguishedname']) && isset($results[$i]['uid'])){
                    $results[$i]['distinguishedname'] = [];
                    array_push($results[$i]['distinguishedname'], 'uid='.$results[$i]['uid'][0].','.$this->ldap->configs['base_dn']);
                }
            }
            return $this->sort($results);
        }else{
            return NULL; 
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