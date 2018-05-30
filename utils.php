<?php
require_once('vendor/autoload.php');

function getGet($key){
    if (isset($_GET[$key])) { 
        return $_GET[$key];  
    }else{  
        return NULL;
    }
}
function getPost($key){
    if (isset($_POST[$key])) { 
        return $_POST[$key];  
    }else{  
        return NULL;
    }
}
function echoArr($arr){
    if(is_array($arr)){
        if(count($arr) == 1){
            echo $arr[0];
        }else if(count($arr) > 1){
            foreach($arr as $val){
                echo $val.'<br>';
            }
        } else{
            echo '';
        }
    } else {
        echo $arr;
    }
}
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