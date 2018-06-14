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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>LDAP Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/lamweb.css">
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  if($file != 'login.php'){  
?>
<div class="container-fruid"> 
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/index.php"><?php t_('My Profile');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/views/user/users.php"><?php t_('Users');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/views/group/groups.php"><?php t_('Groups');?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="/views/organization/organizations.php"><?php t_('Organizations');?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="#"><?php t_('Import');?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="#"><?php t_('Export');?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="/views/settings/settings.php"><?php t_('Settings');?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="/logout.php">| <?php t_('Logout');?></a>
        </li> 
      </ul>
    </div>
  </nav> 
</div>
<?php
  }
?>