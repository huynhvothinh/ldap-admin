<?php
class MyGroup{
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

    function get_fields_detail(){
        return $this->ldap->configs['fields']['group']['detail'];
    }

    function get_fields_edit(){
        return $this->ldap->configs['fields']['group']['edit'];
    }

    function get_item($id){    
        $filters = '(&(cn=%s)%s)'; 
        $filters = sprintf($filters, $id, $this->ldap->configs['group_filter']); 
        
        $results = $this->ldap->search($filters);
        if($results)
            return $results[0];
        else
            return NULL; 
    }

    function get_list(){      
        $filters = $this->ldap->configs['group_filter']; 
        $results = $this->ldap->search($filters);
        if($results)
            return $this->sort($results);
        else
            return NULL; 
    } 
}
// 
function compareGroup($a, $b) {
    return strcmp($a["cn"][0], $b["cn"][0]);
} 
?>