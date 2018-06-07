<?php
//https://github.com/Adldap2/Adldap2/blob/v8.0/docs/models/user.md

// 
function compareUser($a, $b) {
    return strcmp($a["uid"][0], $b["uid"][0]);
} 
function sortUsers($users){
    $arr = [];
     
    for($index = 0; $index < count($users); $index++) {
        array_push($arr, $users[$index]);  
    }

    usort($arr, 'compareUser');

    return $arr;
} 
// 
function ldapGetUserModel($configs, $uid){    
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $ldapuser = $provider->search()
            ->where([
                'objectClass'=>'organizationalPerson',
                'uid' => $uid 
            ])->firstOrFail();
        
        if ($ldapuser instanceof \Adldap\Models\User) {
            return $ldapuser;
        }else{
            return NULL;
        }
    }catch(Exception $e){
        return NULL;
    }
}

// https://github.com/Adldap2/Adldap2/issues/392
function ldapChangePass($configs, $uid, $password){    
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $ldapuser = $provider->search()
            ->where([
                'objectClass'=>'organizationalPerson',
                'uid' => $uid 
            ])->firstOrFail();
        
        if ($ldapuser instanceof \Adldap\Models\User) {
            $ldapUser["userPassword"] = "{MD5}" . base64_encode(pack('H*', md5($password)));
            if(@$ldapUser->save()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }catch(Exception $e){
        return false;
    }
}

// 
function ldapGetUser($configs, $uid){
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $users = $provider->search()
            ->where([
                'objectClass'=>'organizationalPerson',
                'uid' => $uid 
            ])->get();
        
        if($users && count($users) > 0)
            return $users[0];
        else
            return NULL;
    }catch(Exception $e){
        return NULL;
    }
}
function ldapGetUsers($configs){
    try{
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP); 
        $users = $provider->search()
            ->where('objectClass','organizationalPerson')
            ->select(['uid', 'cn', 'sn'])->get();
        
        if($users)
            return $users;
        else
            return [];
    }catch(Exception $e){
        return [];
    }
} 
//
function ldapCurrentUser($configs){   
    try { 
        $provider = new \Adldap\Connections\Provider($configs, 
            new \Adldap\Connections\Ldap, 
            new \Adldap\Schemas\OpenLDAP);
        if ($provider->auth()->attempt(
            'uid='.$configs['admin_username'].',dc=example,dc=com', $configs['admin_password']
            )) { 
            // Credentials were correct.
            return $provider->search()->users()->find($configs['admin_username']);
        } else {
            // Credentials were incorrect.  
            return false;
        } 
    
    } catch (\Adldap\Auth\UsernameRequiredException $e) {
        // The user didn't supply a username. 
        return false;
    } catch (\Adldap\Auth\PasswordRequiredException $e) {
        echo '11';
        // The user didn't supply a password. 
        return false;
    } catch(Exception $e){
        return false;
    }
}
//
function ldapAuth($configs){   
    try {
        if($configs['admin_username'] == ''){
            // Construct new Adldap instance.
            $ad = new \Adldap\Adldap();         
            // Add a connection provider to Adldap.
            $ad->addProvider($configs);

            $provider = $ad->connect('default');
            $provider->setSchema(new \Adldap\Schemas\OpenLDAP());
            return true;
        }else{
            $provider = new \Adldap\Connections\Provider($configs, new \Adldap\Connections\Ldap, new \Adldap\Schemas\OpenLDAP);
            if ($provider->auth()->attempt(
                'uid='.$configs['admin_username'].',dc=example,dc=com', $configs['admin_password']
                )) { 
                // Credentials were correct.
                return true;
            } else {
                // Credentials were incorrect.  
                return false;
            }
        }
    
    } catch (\Adldap\Auth\UsernameRequiredException $e) {
        // The user didn't supply a username. 
        return false;
    } catch (\Adldap\Auth\PasswordRequiredException $e) { 
        // The user didn't supply a password. 
        return false;
    } catch(Exception $e){
        return false;
    }
}
?>