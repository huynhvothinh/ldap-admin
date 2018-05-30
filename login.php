<?php
include 'header.php';
include 'config.php';
include 'utils.php';
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

$value = getPost('port');
if($value != NULL){
  $configs['port'] = $value;
}

$value = getPost('port');
if($value != NULL){
  $configs['port'] = $value;
}

$value = getPost('admin_account_prefix');
if($value != NULL){
  $configs['admin_account_prefix'] = $value;
}

$value = getPost('admin_account_suffix');
if($value != NULL){
  $configs['admin_account_suffix'] = $value;
}

$value = getPost('use_tls');
if($value != NULL){
  $configs['use_tls'] = $value;
}

// ldap auth
if(getPost('form_submitted') != NULL){
  if(ldapAuth($configs)){
    // session
    session_start();
    $_SESSION["config"] = $configs;
    $_SESSION["admin_username"] = $configs['admin_username'];
    $_SESSION["admin_password"] = $configs['admin_password'];

    // 
    header("Location: index.php"); /* Redirect browser */
    exit();
  }
}
?>

<div class="container login">
  <form action="login.php" method="post" class="<?php echo (getPost('advanced_options') != NULL ? 'advanced' : ''); ?>">
    <h2>Login</h2>
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
      <button type="submit" class="btn btn-primary">Login</button>
    </div> 
    <div class="form-check">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="advanced_options" id="advanced_options" <?php echo (getPost('advanced_options') != NULL ? 'checked' : ''); ?>> <strong>Advanced options</strong>
      </label>
    </div>
    <div class="form-group advanced_field">
      <label for="host">Host:</label>
      <input type="text" class="form-control" name="domain_controllers" id="domain_controllers" value="<?php echo $configs['domain_controllers'][0];?>">
    </div> 
    <div class="form-group advanced_field">
      <label for="base_dn">Base DN:</label>
      <input type="text" class="form-control" name="base_dn" id="base_dn" value="<?php echo $configs['base_dn'];?>">
    </div> 
    <div class="form-group advanced_field">
      <label for="base_dn">Port:</label>
      <input type="text" class="form-control" name="port" id="port" value="<?php echo $configs['port'];?>">
    </div> 
    <div class="form-group advanced_field">
      <label for="admin_account_prefix">Admin account prefix:</label>
      <input type="text" class="form-control" name="admin_account_prefix" id="base_dn" value="<?php echo $configs['admin_account_prefix'];?>">
    </div> 
    <div class="form-group advanced_field">
      <label for="admin_account_suffix">Admin account suffix:</label>
      <input type="text" class="form-control" name="admin_account_suffix" id="admin_account_suffix" value="<?php echo $configs['admin_account_suffix'];?>">
    </div> 
    <div class="form-check advanced_field">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="use_ssl" id="use_ssl" <?php echo ($configs['use_ssl'] ? 'checked' : '');?>> Use SSL
      </label>
    </div>
    <div class="form-check advanced_field">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="use_tls" id="use_tls" <?php echo ($configs['use_tls'] ? 'checked' : '');?>> Use TLS
      </label>
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