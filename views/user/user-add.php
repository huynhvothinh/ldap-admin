<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_admin($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<?php
include '../../footer-blank.php';
?>