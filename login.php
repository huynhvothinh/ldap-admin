<?php
include 'header.php';
?>

<?php
$settingController = new MySetting();
$default_configs = MyConfig::$default_configs;

$configs = [
  'admin_username' => '',
  'admin_password' => '',
  'admin_account_suffix' => ''
];


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

$value = getPost('admin_account_suffix'); 
if($value != NULL){
  $configs['admin_account_suffix'] = $value;
}else{
  $configs['admin_account_suffix'] = '';
}

// ldap auth
$message = '';
if(getPost('form_submitted') != NULL){
  $ldapController = new MyLdap($configs);
  if($ldapController->auth()){
    // session
    session_start();
    $_SESSION["config"] = $configs;

    // 
    header("Location: index.php"); /* Redirect browser */
    exit();
  }else{
    $message = t_value( 'Login failed');
  }
}
?>

<div class="container login">
  <form action="login.php" method="post">
    <h2><?php t_('Login');?></h2>

    <?php if($message){?>
    <p class="alert alert-warning"><?php t_($message);?></p>
    <?php } ?>
    
    <input type="hidden" value="1" name="form_submitted">
    <div class="form-group">
      <label for="admin_username"><?php t_('Account');?></label>
      <input type="text" class="form-control" name="admin_username" id="admin_username" value="<?php echo $default_configs['admin_username'];?>">
    </div> 
    <div class="form-group">
      <label for="admin_password"><?php t_('Password');?></label>
      <input type="password" class="form-control" name="admin_password" id="admin_password" value="<?php echo $default_configs['admin_password'];?>">
    </div> 
    <div class="form-group">
      <label for="admin_account_suffix"><?php t_('Account suffix (Ex: cn=Users)');?></label>  
      <div class="text-dropdown">
        <input type="text" name="admin_account_suffix" id="admin_account_suffix" 
          class="form-control" value="<?php echo $configs['admin_account_suffix']; ?>">
        <div class="dropdown admin_account_suffix">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
          <div class="dropdown-menu dropdown-menu-right"> 
            <?php 
              $account_suffix_arr = $settingController->get_account_suffix();
              if(is_array($account_suffix_arr)){
                foreach($account_suffix_arr as $suffix){ 
                  echo '<a class="dropdown-item" href="#" data-value="'.$suffix.'">'.$suffix.'</a>'; 
                }
              }
            ?>
          </div>
        </div> 
      </div>
    </div> 
    <div class="form-group">
      <button type="submit" class="btn btn-primary"><?php t_('Login');?></button>
    </div> 
    <div class="form-group">
      <label for="host"><?php t_('Host');?></label>
      <input type="text" disabled class="form-control" name="domain_controllers" id="domain_controllers" value="<?php echo $default_configs['domain_controllers'];?>">
    </div> 
    <div class="form-group">
      <label for="base_dn"><?php t_('Base DN');?></label>
      <input type="text" disabled class="form-control" name="base_dn" id="base_dn" value="<?php echo $default_configs['base_dn'];?>">
    </div> 
  </form>
</div>

<script>
  jQuery(document).ready(function(){
    jQuery('.dropdown.admin_account_suffix .dropdown-item').click(function(){ 
      jQuery('#admin_account_suffix').val(jQuery(this).attr('data-value'));
    }); 
  });
</script>


<?php
include 'footer.php';
?>