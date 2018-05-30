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