<?php
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
function getArrayValue($arr, $key, $level1=true, $default=''){
    if(is_array($arr)){
        if(isset($arr[$key])){
            if($level1 == 1){
                return $arr[$key];
            }else{
                if(is_array($arr[$key])){
                    if(count($arr[$key]) > 0){ 
                        return $arr[$key][0];
                    } else{
                        return $default;
                    }
                }else{
                    return $arr[$key];
                }
            }
        }else{
            return $default;
        }
    }else{
        return $default;
    }
}
function echoArr($arr){
    if(is_array($arr)){
        if(count($arr) == 1){
            echo $arr[0];
        }else if(count($arr) > 1){
            for($i=0;$i<count($arr);$i++){                
                if(array_key_exists($i, $arr))
                    echo $arr[$i].'<br>';
            }
        } else{
            echo '';
        }
    } else {
        echo $arr;
    }
}
?>