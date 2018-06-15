<?php
class MySetting{
    function get_account_suffix(){
        $data = file_get_contents(dirname(__FILE__).'/../config/account_suffix.json');
        if($data){
            $arr = json_decode($data);
            if($arr)
                return $arr;
            else
                return [];
        }else{
            return [];
        }
    }
    function save_account_suffix($data){
        if(!$data){
            $data = [];
        }
        file_put_contents(dirname(__FILE__).'/../config/account_suffix.json', $data);  
    }

} 
?>