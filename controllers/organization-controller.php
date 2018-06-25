<?php
class MyOrganization{
    public $ldap = NULL; 

    function __construct($configs){
        $ldap = new MyLdap($configs);
        $this->ldap = $ldap;
    }   

    function get_fields_list(){
        return $this->ldap->configs['fields']['organization']['list'];
    }  

    function get_list(){     
        $filters = $this->ldap->configs['organization_filter'];

        $results = $this->ldap->search_root($filters);
        if($results){
            for($i=0;$i<count($results);$i++){
                if(!isset($results[$i]['distinguishedname']) && isset($results[$i]['cn'])){
                    $results[$i]['distinguishedname'] = [];
                    array_push($results[$i]['distinguishedname'], 'cn='.$results[$i]['cn'][0].','.$this->ldap->configs['base_dn']);
                }
            }
            return $results;
        }else{
            return NULL; 
        }
    } 

    function get_list_for_suffix(){
        $arr = $this->get_list();
        $list = [];
        for($i=0; $i<count($arr); $i++){
            if(isset($arr[$i])){
                $item = $arr[$i];
                if(isset($item['ou'])){
                    array_push($list, 'OU='.$item['ou'][0]);
                }
                else if(isset($item['cn'])){
                    array_push($list, 'CN='.$item['cn'][0]);
                }
            }
        }
        return $list;
    }
}  
?>