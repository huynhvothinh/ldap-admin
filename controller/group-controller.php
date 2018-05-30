<?php
require_once('vendor/autoload.php');
// 
function compareGroup($a, $b) {
    return strcmp($a["sn"][0], $b["sn"][0]);
} 
function sortGroups($groups){
    $arr = [];
     
    for($index = 0; $index < count($groups); $index++) {
        array_push($arr, $groups[$index]);  
    }

    usort($arr, 'compareGroup');

    return $arr;
} 
//
function ldapGetGroup($configs, $ou){
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $groups = $provider->search()
            ->where([
                'objectClass'=>'groupOfUniqueNames',
                'ou' => $ou 
            ])->get();
        
        if($groups && count($groups) > 0)
            return $groups[0];
        else
            return NULL;
    }catch(Exception $e){
        return NULL;
    }
}
function ldapGetGroups($configs){
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $groups = $provider->search()->where('objectClass','groupOfUniqueNames')->select(['cn', 'ou'])->get();
        
        if($groups)
            return $groups;
        else
            return [];
    }catch(Exception $e){
        return [];
    }
} 

?>