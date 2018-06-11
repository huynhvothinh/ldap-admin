<?php
class MyRole{
    public $ldap = NULL; 

    function __construct($configs){
        $ldap = new MyLdap($configs);
        $this->ldap = $ldap; 
    } 
    
    function sort($list){
        if(is_array($list) && count($list) > 0){
            $arr = [];
            
            for($index = 0; $index < count($list); $index++) {
                if(array_key_exists($index, $list))
                    if(array_key_exists('cn', $list[$index]))
                        array_push($arr, $list[$index]);  
            }

            usort($arr, 'compareGroup');

            return $arr;                
        }else{
            return $list;
        }
    } 

    function get_item($id){        
        if($this->ldap->auth()){  
            $filters = '(&(cn=%s)%s)'; 
            $filters = sprintf($filters, $id, $this->ldap->configs['role_filter']); 
            
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
            $filters = $this->ldap->configs['role_filter']; 
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
function compareRole($a, $b) {
    return strcmp($a["cn"][0], $b["cn"][0]);
} 
?>