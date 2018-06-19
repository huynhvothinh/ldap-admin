<?php
include 'header.php';
?>

<?php
$settingController = new MySetting(); 

// list all basedn
$basedn_list = get_basedn_list();

// post configs
$configs = [
  'admin_username' => '',
  'admin_password' => '',
  'admin_account_prefix' => '',
  'admin_account_suffix' => '',
  'domain_controllers' => '',
  'base_dn' => '',
  'port' => 686,
  'use_ssl' => true
];
$configs = get_post_configs($configs);

// set default base dn
if(count($basedn_list) > 0){
  if($configs['base_dn'] == NULL){
    $configs['base_dn'] = $basedn_list[0]['BASEDN_CODE'];
  }
}

// default configs, if submited, will get default from posting
$default_configs = MyConfig::$default_configs;
$default_configs = $settingController->load_db_configs($default_configs, $configs['base_dn']); 

// ldap auth
$message = '';
if(getPost('basedn_changed') == '1'){
  $configs['admin_account_suffix'] = '';
}else if(getPost('form_submitted') != NULL){
  // update config  
  $default_configs['admin_username'] = $configs['admin_username'];
  $default_configs['admin_password'] = $configs['admin_password'];
  $default_configs['domain_controllers'] = $configs['domain_controllers'];
  $default_configs['base_dn'] = $configs['base_dn'];
  $default_configs['port'] = $configs['port'];
  $default_configs['use_ssl'] = $configs['use_ssl'];
  $default_configs['admin_account_prefix'] = $configs['admin_account_prefix'];
  $default_configs['admin_account_suffix'] = $configs['admin_account_suffix'];
  
  $ldapController = new MyLdap($default_configs); 

  if($ldapController->auth()){
    $settingController->save_db_configs($default_configs);
    // session
    session_start();
    $_SESSION["config"] = $default_configs;

    // 
    header("Location: index.php"); /* Redirect browser */
    exit();
  }else{
    $message = t_value( 'Login failed');
  }
} 
?>

<div class="container login">
  <form action="login.php" method="post" id="login">
    <h2><?php t_('Login');?></h2>

    <?php if($message){?>
    <p class="alert alert-warning"><?php t_($message);?></p>
    <?php } ?>
    
    <input type="hidden" value="1" name="form_submitted">
    <input type="hidden" value="0" name="basedn_changed">
    
    <div class="form-group">
      <label for="base_dn"><?php t_('Base DN');?></label>  
      <div class="text-dropdown">
        <input type="text" name="base_dn" id="base_dn" 
          class="form-control" value="<?php echo $configs['base_dn']; ?>">
        <div class="dropdown base_dn">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
          <div class="dropdown-menu dropdown-menu-right"> 
            <?php 
              if(is_array($basedn_list)){
                foreach($basedn_list as $item){ 
                  echo '<a class="dropdown-item" href="#" data-value="'.$item['BASEDN_CODE'].'">'.$item['BASEDN_CODE'].'</a>'; 
                }
              }
            ?>
          </div>
        </div> 
      </div>
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
              $account_suffix_arr = $default_configs['admin_account_suffix_arr']; 
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
      <label for="admin_username"><?php t_('Account');?></label>
      <input type="text" class="form-control" name="admin_username" id="admin_username" value="<?php echo $default_configs['admin_username'];?>">
    </div> 
    <div class="form-group">
      <label for="admin_password"><?php t_('Password');?></label>
      <input type="password" class="form-control" name="admin_password" id="admin_password" value="<?php echo $default_configs['admin_password'];?>">
    </div> 
    <div class="form-group">
      <button type="submit" class="btn btn-primary"><?php t_('Login');?></button>  
      <a href="#" data-toggle="modal" data-target="#loginModal">
        Advanced login
      </a>
    </div> 
    
    <!-- The Modal -->
    <div class="modal" id="loginModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title"><?php t_('Advanced login'); ?></h4>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            
            <div class="form-group">
              <label for="host"><?php t_('Host');?></label>
              <input type="text" class="form-control" name="domain_controllers" id="domain_controllers" value="<?php echo $default_configs['domain_controllers'];?>">
            </div>   
            <div class="form-group">
              <label for="port"><?php t_('Port');?></label>
              <input type="text" class="form-control" name="port" id="port" value="<?php echo $default_configs['port'];?>">
            </div> 
            <div class="form-group">
              <label for="use_ssl"><?php t_('Use SSL');?></label>
              <input type="checkbox" class="form-control" name="use_ssl" id="use_ssl" <?php echo ($default_configs['use_ssl'] == '1' ? 'checked' : '');?> value="1">
            </div> 
            <div class="form-group">
              <label for="admin_account_prefix"><?php t_('Account prefix');?></label>
              <input type="text" class="form-control" name="admin_account_prefix" id="admin_account_prefix" value="<?php echo $default_configs['admin_account_prefix'];?>">
            </div>   
          </div> 

        </div>
      </div>
    </div>
  </form>
</div>

<script>
  jQuery(document).ready(function(){
    jQuery('.dropdown.admin_account_suffix .dropdown-item').click(function(){ 
      jQuery('#admin_account_suffix').val(jQuery(this).attr('data-value'));
    }); 
    jQuery('.dropdown.base_dn .dropdown-item').click(function(){ 
      jQuery('#base_dn').val(jQuery(this).attr('data-value'));
      jQuery('input[name="basedn_changed"').val(1);
      jQuery('#login').submit();
    }); 

    <?php     
    if(getPost('basedn_changed') == '1'){
      echo "jQuery('.dropdown.admin_account_suffix .dropdown-item').first().click();";
    }
    ?>
  });
</script>

<?php
include 'footer.php';
?>

<?php
function get_basedn_list(){ 
  $baseDN = new MyBaseDNDB();
  $arr = $baseDN->get_list(true);

  $list = array();
  if(count($arr) > 0){
    for($i=0; $i<count($arr); $i++){
      $item = array();
      $item['BASEDN_CODE'] = $arr[$i]['BASEDN_CODE'];
      $item['ACCOUNT_SUFFIX_ARR'] = $arr[$i]['ACCOUNT_SUFFIX_ARR'];
      array_push($list, $item);
    }    
  }
  return $list;
}
function get_post_configs($configs){
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

  $value = getPost('admin_account_prefix'); 
  if($value != NULL){
    $configs['admin_account_prefix'] = $value;
  }

  $value = getPost('admin_account_suffix'); 
  if($value != NULL){
    $configs['admin_account_suffix'] = $value;
  }

  $value = getPost('domain_controllers'); 
  if($value != NULL){
    $configs['domain_controllers'] = $value;
  }

  $value = getPost('base_dn'); 
  if($value != NULL){
    $configs['base_dn'] = $value;
  }

  $value = getPost('port'); 
  if($value != NULL){
    $configs['port'] = $value;
  }

  $value = getPost('use_ssl'); 
  if($value == '1'){
    $configs['use_ssl'] = true;
  }else{
    $configs['use_ssl'] = false;
  }

  return $configs;
}
?>