<?php
class MyUser{
    public $ldap = NULL;
    public $user_id_key = '';

    function __construct($configs){
        $ldap = new MyLdap($configs);
        $this->ldap = $ldap;
        $this->user_id_key = str_replace('=', '', $this->ldap->configs['admin_account_prefix']);
    } 

    function sort($list){
        if(is_array($list) && count($list) > 0){
            $arr = []; 
            for($index = 0; $index < count($list); $index++) {
                if(array_key_exists($index, $list)) 
                    if(array_key_exists($this->user_id_key, $list[$index]))
                        array_push($arr, $list[$index]);  
            }

            if($this->user_id_key == 'uid')
                usort($arr, 'compareUserUID');
            else
                usort($arr, 'compareUserCN');
        
            return $arr;
        }else{
            return $list;
        }
    }  

    function get_fields_detail(){
        return $this->ldap->configs['user_detail_fields'];
    }

    function get_fields_edit(){
        return $this->ldap->configs['user_edit_fields'];
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
        if($this->ldap->auth()){  
            $filters = '(&(%s=%s)%s)'; 
            $filters = sprintf($filters, $this->user_id_key, $id, $this->ldap->configs['user_filter']); 

            $results = $this->ldap->search($filters);
            if(is_array($results) && count($results)>0)
                return $results[0];
            else
                return NULL;
        }else{
            return NULL;
        }
    }
    
    function get_list(){
        if($this->ldap->auth()){  
            $filters = $this->ldap->configs['user_filter'];
            $results = $this->ldap->search($filters);

            if($results)
                return $this->sort($results);
            else
                return NULL;
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