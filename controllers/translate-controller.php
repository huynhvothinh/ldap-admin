<?php 
$lang = 'vi';
function t_($key){
    $lang = $GLOBALS['lang'];
    $arr = MyTranslate::get_translates();
    if(is_array($arr) && array_key_exists($key, $arr)){
        if(is_array($arr[$key]) && array_key_exists($lang, $arr[$key])){
            echo $arr[$key][$lang];
            return;
        }
    }
    echo $key;
}
function t_value($key){ 
    $lang = $GLOBALS['lang'];
    $arr = MyTranslate::get_translates();
    if(is_array($arr) && array_key_exists($key, $arr)){
        if(is_array($arr[$key]) && array_key_exists($lang, $arr[$key])){
            return $arr[$key][$lang]; 
        }
    }
    return $key;
}

class MyTranslate{
    public static $translates = NULL;
    public static function get_translates(){
        if(MyTranslate::$translates){
            return MyTranslate::$translates;
        }else{
            $data = file_get_contents(dirname(__FILE__).'/../i18n/translates.json');
            MyTranslate::$translates = json_decode($data, true);
            return MyTranslate::$translates;
        }
    }
}

?>