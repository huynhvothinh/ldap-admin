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