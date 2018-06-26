<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php 
$permissionController = new MyPermission($configs);

$message = '';   

$permissions = $permissionController->load_basedn_permissions($configs['base_dn']);

$value = NULL;
$value = getPost('super_users');
if($value){
    $permissions['super']['users'] = explode(';', $value);
}

$value = getPost('super_groups');
if($value){
    $permissions['super']['groups'] = explode(';', $value);
}

$value = getPost('admin_users');
if($value){
    $permissions['admin']['users'] = explode(';', $value);
}

$value = getPost('admin_groups');
if($value){
    $permissions['admin']['groups'] = explode(';', $value);
}

if(getPost('form_submitted') != NULL){ 
    // no edit basedn
    $permissionController->save_basedn_permissisons($configs['base_dn'], $permissions);
    $message = t_value('Successfully');
}
?>

<div class="container-fruid settings">  
    
    <form action="/views/settings/permissions.php" method="post" id="settings"> 

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>
        
        <input type="hidden" value="1" name="form_submitted">
        
        <div class="form-group">
            <label for="host"><?php t_('Super users (user 1; user 2)');?></label>
            <input type="text" class="form-control" name="super_users" id="super_user" value="<?php echo implode(';', $permissions['super']['users']);?>">
        </div>  
        <div class="form-group" style="display:none;">
            <label for="host"><?php t_('Super groups (group 1; group 2)');?></label>
            <input type="text" class="form-control" name="super_groups" id="super_groups" value="<?php echo implode(';', $permissions['super']['groups']);?>">
        </div>  
        <div class="form-group">
            <label for="host"><?php t_('Admin users (user 1; user 2)');?></label>
            <input type="text" class="form-control" name="admin_users" id="admin_users" value="<?php echo implode(';', $permissions['admin']['users']);?>">
        </div>  
        <div class="form-group" style="display:none;">
            <label for="host"><?php t_('Admin groups (group 1; group 2)');?></label>
            <input type="text" class="form-control" name="admin_groups" id="admin_groups" value="<?php echo implode(';', $permissions['admin']['groups']);?>">
        </div>  
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php t_('Save');?></button>   
        </div> 
    </form>
</div> 

<?php
include '../../footer.php';
?>