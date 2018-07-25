<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<?php
    // session
    session_start();
    if(!$_SESSION["config"]){
        // 
        header("Location: login.php"); /* Redirect browser */
        exit();
    } 
?>
<?php 
require_once('../../include.php');
// 
$configs = $_SESSION['config']; 
$PERMISSION_CONTROLLER = new MyPermission($configs);
$userController = new MyUser($configs); 
$user = $userController->get_item($configs['admin_username']);    
$USER_PERMISSION_KEY = $PERMISSION_CONTROLLER->get_user_permission($configs['base_dn'], $user); 
?>
<?php
    if(!$PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>
<?php   
    if(getPost('form_submitted') != NULL){   
        $userController = new MyUser($configs);   
        $arr = $userController->get_list(); 

        $data = "username,ou\n";
        foreach($arr as $user){
            $data .= '"'.$user[$userController->user_id_key][0] .'","'. $user['distinguishedname'][0].'"'."\n";
        }

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="export-users.csv"');
        echo $data; 
        exit();
    }
?>    