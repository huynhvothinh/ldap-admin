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
function getFile($key){
    if (isset($_FILES[$key])) { 
        return $_FILES[$key];  
    }else{  
        return NULL;
    }
}
function getArrayValue($arr, $key, $level1=true, $default=''){
    if(is_array($arr)){
        if(isset($arr[$key])){ 
            // got value
            if(is_array($arr[$key])){
                if(count($arr[$key]) > 0){ 
                    if($level1)
                        return $arr[$key][0];
                    else
                        return $arr[$key];
                } else{
                    return $default;
                }
            }else{
                return $arr[$key];
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
function convertImage($originalImage, $outputImage, $quality){
    // jpg, png, gif or bmp?
    $exploded = explode('.',$originalImage);
    $ext = $exploded[count($exploded) - 1]; 

    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}
?>