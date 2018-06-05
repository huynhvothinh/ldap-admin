<?php 
function t_($key, $lang=NULL){
    $arr = [];
    if($lang == NULL || $lang == 'vi'){
        $arr = $GLOBALS['TRANSLATE_VI']; 
    }
    echo (array_key_exists($key, $arr) ? $arr[$key] : $key);
}
function t_value($key, $lang=NULL){
    $arr = [];
    if($lang == NULL || $lang == 'vi'){
        $arr = $GLOBALS['TRANSLATE_VI']; 
    }
    return (array_key_exists($key, $arr) ? $arr[$key] : $key);
}

?>