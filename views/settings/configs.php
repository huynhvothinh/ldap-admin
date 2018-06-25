<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
$organizationController = new MyOrganization($configs); 
$settingController = new MySetting($configs);

$message = '';  
$arr = $organizationController->get_list_for_suffix();

$default_configs = MyConfig::$default_configs;
$default_configs = $settingController->load_db_configs($default_configs, $configs['base_dn']); 

$default_configs = get_post_configs($default_configs);

if(getPost('form_submitted') != NULL){ 
    // no edit basedn
    $settingController->save_db_configs($default_configs);
    $message = t_value('Successfully');
}
?>

<div class="container-fruid settings">  
    
    <form action="/views/settings/configs.php" method="post" id="settings"> 

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>
        
        <input type="hidden" value="1" name="form_submitted">
        
        <div class="form-group">
            <label for="host"><?php t_('Host');?></label>
            <input type="text" class="form-control" name="domain_controllers" id="domain_controllers" value="<?php echo $default_configs['domain_controllers'];?>">
        </div> 
        <div class="form-group">
            <label for="admin_account_prefix"><?php t_('Account prefix');?></label>
            <input type="text" class="form-control" name="admin_account_prefix" id="admin_account_prefix" value="<?php echo $default_configs['admin_account_prefix'];?>">
        </div>  
        <div class="form-group">
            <label for="admin_account_suffix"><?php t_('Account suffix');?></label>
            <?php for($i=0; $i<count($arr); $i++){ 
                $checked = in_array($arr[$i], $default_configs['admin_account_suffix_arr']) ? 'checked' : '';
            ?>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="admin_account_suffix_arr[]" 
                        <?php echo $checked; ?> value="<?php echo $arr[$i]; ?>"> <?php echo $arr[$i]; ?>
                </label>
            </div>
            <?php } // end for ?>
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
            <label for="base_dn"><?php t_('User filter');?></label>   
            <input type="text" name="user_filter" id="user_filter" 
                class="form-control" value="<?php echo $default_configs['user_filter']; ?>">  
        </div> 
        <div class="form-group">
            <label for="base_dn"><?php t_('Group filter');?></label>   
            <input type="text" name="group_filter" id="group_filter" 
                class="form-control" value="<?php echo $default_configs['group_filter']; ?>">  
        </div> 
        <div class="form-group">
            <label for="base_dn"><?php t_('Organization filter');?></label>   
            <input type="text" name="organization_filter" id="organization_filter" 
                class="form-control" value="<?php echo $default_configs['organization_filter']; ?>">  
        </div> 
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php t_('Save');?></button>   
        </div> 
    </form>
</div> 

<?php
include '../../footer.php';
?>

<?php

function get_post_configs($configs){
    // prepare config
    $value = NULL;    
    $value = getPost('admin_account_prefix'); 
    if($value != NULL){
        $configs['admin_account_prefix'] = $value;
    }

    $value = getPost('admin_account_suffix_arr'); 
    if($value != NULL){
        $configs['admin_account_suffix_arr'] = $value;
    }
  
    $value = getPost('domain_controllers'); 
    if($value != NULL){
        $configs['domain_controllers'] = $value;
    }
  
    $value = getPost('port'); 
    if($value != NULL){
        $configs['port'] = $value;
    }
  
    $value = getPost('use_ssl'); 
    if($value == '1'){
        $configs['use_ssl'] = $value;
    } 
    
    $value = getPost('user_filter'); 
    if($value != NULL){
        $configs['user_filter'] = $value;
    }

    $value = getPost('group_filter'); 
    if($value != NULL){
        $configs['group_filter'] = $value;
    }

    $value = getPost('organization_filter'); 
    if($value != NULL){
        $configs['organization_filter'] = $value;
    }
  
    return $configs;
  }
?>