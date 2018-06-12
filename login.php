<?php
include 'header.php';
require_once('controllers/ldap-controller.php')
?>

<?php

// prepare config
$value = NULL;
$value = getPost('admin_username');
if($value != NULL){
  $configs['admin_username'] = $value;
}

$value = getPost('admin_password');
if($value != NULL){
  $configs['admin_password'] = $value;
}

$value = getPost('domain_controllers'); 
if($value != NULL){
  $configs['domain_controllers'][0] = $value;
}

$value = getPost('base_dn');
if($value != NULL){
  $configs['base_dn'] = $value;
}

$value = getPost('admin_account_suffix'); 
if($value != NULL){
  $configs['admin_account_suffix'] = $value;
}else{
  $configs['admin_account_suffix'] = '';
}

// ldap auth
$message = '';
if(getPost('form_submitted') != NULL){
  $ldap = new MyLdap($configs);
  if($ldap->auth()){
    // session
    session_start();
    $_SESSION["config"] = $configs;

    // 
    header("Location: index.php"); /* Redirect browser */
    exit();
  }else{
    $message = 'Login failed';
  }
}
?>

<div class="container login">
  <form action="login.php" method="post">
    <h2>Login</h2>

    <?php if($message){?>
    <p class="alert alert-warning"><?php t_($message);?></p>
    <?php } ?>
    
    <input type="hidden" value="1" name="form_submitted">
    <div class="form-group">
      <label for="admin_username">Admin Name:</label>
      <input type="text" class="form-control" name="admin_username" id="admin_username" value="<?php echo $configs['admin_username'];?>">
    </div> 
    <div class="form-group">
      <label for="admin_password">Admin Password:</label>
      <input type="password" class="form-control" name="admin_password" id="admin_password" value="<?php echo $configs['admin_password'];?>">
    </div> 
    <div class="form-group">
      <label for="admin_account_suffix">Admin account suffix (Ex: cn=Users):</label>  
      <select name="admin_account_suffix" id="admin_account_suffix" class="form-control"> 
      <?php 
        if(is_array($configs['admin_account_suffix_arr'])){
          foreach($configs['admin_account_suffix_arr'] as $suffix){
            if($suffix == $configs['admin_account_suffix']){
              echo '<option value="'.$suffix.'" selected>'.$suffix.'</option>';
            }else{
              echo '<option value="'.$suffix.'">'.$suffix.'</option>';
            }
          }
        }
      ?>
      </select>
    </div> 
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Login</button>
    </div> 
    <div class="form-group">
      <label for="host">Host:</label>
      <input type="text" disabled class="form-control" name="domain_controllers" id="domain_controllers" value="<?php echo $configs['domain_controllers'];?>">
    </div> 
    <div class="form-group">
      <label for="base_dn">Base DN:</label>
      <input type="text" disabled class="form-control" name="base_dn" id="base_dn" value="<?php echo $configs['base_dn'];?>">
    </div> 
  </form>
</div>

<script>
  jQuery(document).ready(function(){
    jQuery('#advanced_options').change(function(){ 
      jQuery('.login form').toggleClass('advanced');
    });
    
    jQuery('#use_ssl').change(function(){
      jQuery('#use_tls').prop('checked', false);
      jQuery('#port').val(jQuery('#use_ssl').is(':checked') == true ? 636 : 389);
    });
    
    jQuery('#use_tls').change(function(){
      if(jQuery('#use_ssl').is(':checked') == true){
        jQuery('#use_ssl').prop('checked', false);
        jQuery('#use_ssl').change();
      }
    });
  });
</script>


<?php
include 'footer.php';
?>