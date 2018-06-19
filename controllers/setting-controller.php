<?php
class MySetting{

    function get_account_suffix($base_dn){
        $baseDN = new MyBaseDNDB();
        $item =$baseDN->get_item($base_dn);
        if($item){
            $data = $item['ACCOUNT_SUFFIX_ARR'];
            $arr = json_decode($data);
            if($arr)
                return $arr;
            else
                return [];
        }else{
            return [];
        }
    }
    
    function save_account_suffix($base_dn, $data){
        if(!$data){
            $data = "[]";
        }

        $baseDN = new MyBaseDNDB();        
        $item = $baseDN->get_item($base_dn);
        if($item){
            $item['ACCOUNT_SUFFIX_ARR'] = $data;
            $baseDN->edit($item);
        }
    }

    function save_db_configs($default_configs){     
        $baseDN = new MyBaseDNDB();
        $base_dn = $default_configs['base_dn'];
        // add if new
        $baseDN->add($base_dn);
        // get
        $item = $baseDN->get_item($base_dn);

        if($item){
            $item['ACTIVE'] = true;
            $item['HOST'] = $default_configs['domain_controllers'];
            $item['BASEDN_CODE'] = $default_configs['base_dn'];
            $item['PORT'] = $default_configs['port'];
            $item['ACCOUNT_PREFIX'] = $default_configs['admin_account_prefix'];
            $item['ACCOUNT_SUFFIX'] = $default_configs['admin_account_suffix'];
            $item['ACCOUNT_SUFFIX_ARR'] = json_encode($default_configs['admin_account_suffix_arr']);
            $item['SSL'] = $default_configs['use_ssl'];
            $item['USER_FILTER'] = $default_configs['user_filter'];
            $item['GROUP_FILTER'] = $default_configs['group_filter'];
            $item['ORGANIZATION_FILTER'] = $default_configs['organization_filter'];
            
            $baseDN->edit($item);
        }
    }

    function load_db_configs($default_configs, $base_dn){     
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

        if($item){
            $default_configs['domain_controllers'] = $item['HOST'];
            $default_configs['base_dn'] = $item['BASEDN_CODE'];
            $default_configs['port'] = $item['PORT'];
            $default_configs['admin_account_prefix'] = $item['ACCOUNT_PREFIX'];
            $default_configs['admin_account_suffix'] = $item['ACCOUNT_SUFFIX'];
            $default_configs['admin_account_suffix_arr'] = json_decode($item['ACCOUNT_SUFFIX_ARR']);
            $default_configs['use_ssl'] = $item['SSL'];
            $default_configs['user_filter'] = $item['USER_FILTER'];
            $default_configs['group_filter'] = $item['GROUP_FILTER'];
            $default_configs['organization_filter'] = $item['ORGANIZATION_FILTER'];

            if($default_configs['admin_account_suffix_arr'] == NULL){
                $default_configs['admin_account_suffix_arr'] = [];
            }
        }

        return $default_configs;
    }
} 
?>