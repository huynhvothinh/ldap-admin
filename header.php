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
    // if(!$_SESSION["config"]){
    //   // 
    //   header("Location: login.php"); /* Redirect browser */
    //   exit();
    // }
  }
?>

<?php 
require_once('config.php');
require_once('utils.php');
require_once('controller/user-controller.php');
require_once('controller/group-controller.php');
require_once('controller/role-controller.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/lamweb.css">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  if($file != 'login.php'){  
?>
<div class="container-fruid"> 
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">My Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="users.php">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="groups.php">Groups</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="roles.php">Roles</a>
      </li> 
    </ul>
  </nav> 
</div>
<?php
  }
?>