<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];  
$user_key = getGet('item_key');       
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_admin($USER_PERMISSION_KEY)){
        if($user_key != $configs['admin_username']){
            header("Location: /403.php"); /* Redirect browser */
            exit();
        }
    }
?>

<?php
$organizationController = new MyOrganization($configs); 
$userController = new MyUser($configs);
$groupController = new MyGroup($configs);
$fields_arr = $userController->get_custom_fields(); 

$message = ''; 
$custom_data = array();

$account_suffix = getPost('admin_account_suffix');
$suffix_arr = $organizationController->get_list_for_suffix();

$memberof = getPost('memberof');
if(!$memberof){
    $memberof = array();
}
$memberof_arr = $groupController->get_list();

if(getPost('form_submitted') != NULL){   
    foreach($fields_arr as $field){
        $custom_data[$field['FIELD_CODE']] = getPost($field['FIELD_CODE']);
    }
    $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');    
    // 
    if($userObject){        
        // update back to ldap
        $ldapItem = $userController->get_item($user_key);
        if($ldapItem){
            if($PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
                $dn = $ldapItem['distinguishedname'][0];                
                $entry = array(); 

                for($i=0;$i<count($memberof);$i++){
                    $entry['memberof'][$i] = $memberof[$i];
                } 
                $status = $userController->ldap->update($dn, $entry);
                $userObject['AD_DATA'] = json_encode($ldapItem);
            }
            
            // update custom data
            $userObject['CUSTOM_DATA'] = json_encode($custom_data);
            $userController->user_object->edit($userObject);
        }

        $message = 'Successfully';
    }else{
        $message = 'User is not exist in database';
    }
}else{
    $ldapItem = $userController->get_item($user_key); 
    if($ldapItem){
        $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');
        if(!$userObject){
            $userController->user_object->add($configs['base_dn'], $user_key, 'USER', json_encode($ldapItem), '');
            $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');
        }
        $account_suffix = $ldapItem['distinguishedname'][0];
        $account_suffix = str_replace(','.$configs['base_dn'], '', $account_suffix);
        $account_suffix = str_replace($configs['admin_account_prefix'].$user_key.',', '', $account_suffix);

        if(isset($ldapItem['memberof'])){
            $memberof = $ldapItem['memberof'];
        }
    }
    // 
    if($userObject){
        $custom_data = (array)json_decode($userObject['CUSTOM_DATA']);
    }
}
?>

<div class="container">   
    <form action="/views/user/user-edit.php?item_key=<?php echo $user_key;?>" method="post">
        <h3><?php t_('User:');?> <?php echo $user_key;?></h3>

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">
        <input type="hidden" value="<?php echo $user_key;?>" name="item_code"> 
    
        <div class="row">
            <?php for($i=0;$i<count($fields_arr);$i++){
                $field_code = $fields_arr[$i]['FIELD_CODE'];
                $field_name = $fields_arr[$i]['FIELD_NAME'];
                $field_val = getArrayValue($custom_data, $field_code);
            ?>
            <div class="form-group col-md-6 col-12">
                <label for="<?php echo $field_code;?>"><?php t_( $field_name);?></label>
                <input type="text" class="form-control" name="<?php echo $field_code;?>" 
                    id="<?php echo $field_code;?>" value="<?php echo $field_val; ?>">
            </div>  
            <?php } // end for ?>
        </div> 
        
        <?php 
        if($PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){?>
            <div class="row">
                <div class="form-group col-md-6 col-12" style="max-height: 300px; overflow-y: scroll;">
                    <label for="admin_account_suffix"><?php t_('Account suffix');?></label>
                    <?php  
                    for($i=0; $i<count($suffix_arr); $i++){
                        $checked = '';                
                        if($account_suffix){
                            // current select
                            if($account_suffix == $suffix_arr[$i]){
                                $checked = 'checked';
                            }
                        }else{
                            // default
                            if($i == 0){
                                $checked = 'checked';
                            }
                        }
                    ?> 
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" style="color:gray;" disabled name="admin_account_suffix" <?php echo $checked;?> 
                                value="<?php echo $suffix_arr[$i]; ?>"> <?php echo $suffix_arr[$i]; ?>
                        </label>
                    </div> 
                    <?php } // end for ?>
                </div>    
                <div class="form-group col-md-6 col-12" style="max-height: 300px; overflow-y: scroll;">
                    <label for="memberof"><?php t_('Groups');?></label>
                    <?php  
                    for($i=0; $i<count($memberof_arr); $i++){
                        $checked = ''; 
                        $key = $memberof_arr[$i]['distinguishedname'][0]; 
                        // current select
                        if(in_array($key, $memberof)){
                            $checked = 'checked';
                        } 
                    ?> 
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="memberof[]" <?php echo $checked;?> 
                                value="<?php echo $key; ?>"> <?php echo $key; ?>
                        </label>
                    </div> 
                    <?php } // end for ?>
                </div>        
            </div>  
        <?php } // end if permisison ?>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>  
    </form> 
</div>

<?php
include '../../footer-blank.php';
?>