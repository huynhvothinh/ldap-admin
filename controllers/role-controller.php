<?php
// 
function compareRole($a, $b) {
    return strcmp($a["cn"][0], $b["cn"][0]);
} 
function sortRoles($roles){
    $arr = [];
     
    for($index = 0; $index < count($roles); $index++) {
        array_push($arr, $roles[$index]);  
    }

    usort($arr, 'compareRole');
    
    return $arr;
}
// 
function ldapGetRole($configs, $cn){
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $roles = $provider->search()
            ->where([
                'objectClass'=>'organizationalRole',
                'cn' => $cn 
            ])->get();
        
        if($roles && count($roles) > 0)
            return $roles[0];
        else
            return NULL;
    }catch(Exception $e){
        return NULL;
    }
}
function ldapGetRoles($configs){
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $roles = $provider->search()
            ->where('objectClass','organizationalRole')
            ->select(['cn', 'description'])->get();
        
        if($roles)
            return $roles;
        else
            return [];
    }catch(Exception $e){
        return [];
    }
} 
?>