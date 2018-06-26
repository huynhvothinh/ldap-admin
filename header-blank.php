<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
?>
<?php
  $file = basename($_SERVER['PHP_SELF']);
  if($file != 'login.php'){    
    // session
    session_start();
    if(!$_SESSION["config"]){
      // 
      header("Location: login.php"); /* Redirect browser */
      exit();
    }
  }
?>

<?php 
require_once('include.php'); 
// 
$configs = $_SESSION['config']; 
$PERMISSION_CONTROLLER = new MyPermission($configs);
$userController = new MyUser($configs); 
$user = $userController->get_item($configs['admin_username']);    
$USER_PERMISSION_KEY = $PERMISSION_CONTROLLER->get_user_permission($configs['base_dn'], $user); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/lamweb.css">
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
</head>
<body>