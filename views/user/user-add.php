<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<?php
$organizationController = new MyOrganization($configs); 
$userController = new MyUser($configs);
$groupController = new MyGroup($configs);
$fields_arr = $userController->get_custom_fields(); 

$message = ''; 
$user_key = getPost('user_key');

$account_suffix = getPost('admin_account_suffix');
$suffix_arr = $organizationController->get_list_for_suffix();

$custom_data = array();
foreach($fields_arr as $field){
    $custom_data[$field['FIELD_CODE']] = getPost($field['FIELD_CODE']);
}

if(getPost('form_submitted') != NULL){   
    if($user_key){ 
        $dn = sprintf('%s%s,%s,%s',
            $configs['admin_account_prefix'],
            trim($user_key),
            $account_suffix,
            $configs['base_dn']
        );
        
        $entry = array();
        $entry['objectclass'][0] = "top";
        $entry['objectclass'][1] = "person";
        $entry['objectclass'][2] = "organizationalPerson";
        $entry['objectclass'][3] = "user";

        // add user ldap
        $status = $userController->ldap->add($dn, $entry);
        
        if($status){
            $ldapItem = $userController->get_item($user_key); 
            if($ldapItem){
                // add/edit user object
                $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');
                if($userObject){
                    $userObject['AD_DATA'] = json_encode($ldapItem);
                    $userObject['CUSTOM_DATA'] = json_encode($custom_data);
                    $userController->user_object->edit($userObject);
                }else{
                    $userController->user_object->add($configs['base_dn'], $user_key, 'USER', 
                        json_encode($ldapItem), json_encode($custom_data)); 
                }
            }
            $message = 'Successfully';
        }else{
            $message = 'Cannot add user';
        }        
    }else{
        $message = 'User code is required';
    }
}
?>

<div class="container">   
    <form action="/views/user/user-add.php" method="post">
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">

        <div class="row">
            <div class="form-group col-md-6 col-12">
                <label for="user_key"><?php t_('User login name, ex: admin (*)');?></label>
                <input type="text" class="form-control" name="user_key" 
                    id="user_key" value="<?php echo $user_key; ?>">
            </div>  
            <div class="form-group col-md-6 col-12" style="max-height: 200px; overflow-y: scroll;">
                <label for="admin_account_suffix"><?php t_('Organizations');?></label>
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
                        <input type="radio" class="form-check-input" name="admin_account_suffix" <?php echo $checked;?> 
                            value="<?php echo $suffix_arr[$i]; ?>"> <?php echo $suffix_arr[$i]; ?>
                    </label>
                </div> 
                <?php } // end for ?>
            </div>       
        </div>  

        <div class="row">
            <?php for($i=0;$i<count($fields_arr);$i++){
                $field_code = $fields_arr[$i]['FIELD_CODE'];
                $field_name = $fields_arr[$i]['FIELD_NAME'];
                $field_val = getArrayValue($custom_data, $field_code);
            ?>
                <div class="form-group  col-md-6 col-12">
                    <label for="<?php echo $field_code;?>"><?php t_( $field_name);?></label>
                    <input type="text" class="form-control" name="<?php echo $field_code;?>" 
                        id="<?php echo $field_code;?>" value="<?php echo $field_val; ?>">
                </div> 
            <?php } // end for ?> 
        </div> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php t_('Save');?></button>
        </div>  
    </form> 
</div>


<?php
include '../../footer-blank.php';
?>