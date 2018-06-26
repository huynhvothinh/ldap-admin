<?php
require_once(dirname(__FILE__).'/../db/fields.php');

class MyPermission{ 
    function save_basedn_permissisons($base_dn, $permissions){     
        $baseDN = new MyBaseDNDB(); 
        // get
        $item = $baseDN->get_item($base_dn); 

        if($item){ 
            $item['PERMISSIONS'] = json_encode($permissions);
            
            $baseDN->edit($item);
        }
    }
    function load_basedn_permissions($base_dn){      
        $baseDN = new MyBaseDNDB();
        $item = NULL;

        if($base_dn){             
            $item = $baseDN->get_item($base_dn);
        }else{
            $arr = $baseDN->get_list(true);
            if(count($arr > 0)){
                $item = $arr[0];
            }
        }

        $permissions = [
            'super' => [
                'users' => [],
                'groups' => []
            ],
            'admin' => [
                'users' => [],
                'groups' => []
            ]
        ];

        if($item){
            $per = json_decode($item['PERMISSIONS']); 
            if($per){
                $permissions['super']['users'] = $per->super->users;
                $permissions['super']['groups'] = $per->super->groups;
                $permissions['admin']['users'] = $per->admin->users;
                $permissions['admin']['groups'] = $per->admin->groups;
            }
        }

        return $permissions;
    }

    function get_user_permission($base_dn, $user){
        $super_arr = MyConfig::$default_configs['super_permission_users'];
        if(in_array($user['user_key'], $super_arr)){
            return 'SUPER';
        }

        $permissions = $this->load_basedn_permissions($base_dn);
        if($user){
            $user_key = $user['user_key'];
            if(in_array($user_key, $permissions['super']['users'])){
                return 'SUPER';
            }else if(in_array($user_key, $permissions['admin']['users'])){
                return 'ADMIN';
            }
        }
        
        return '';
    }

    function check_admin($key){
        if(in_array($key, ['SUPER', 'ADMIN'])){
            return true;
        }else{
            return false;
        }
    }

    function check_super($key){
        if(in_array($key, ['SUPER'])){
            return true;
        }else{
            return false;
        }
    }
} 
?>