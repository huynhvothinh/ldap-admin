<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_admin($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<?php
$userController = new MyUser($configs);
$fields_arr = $userController->get_custom_fields(); 

$message = ''; 
$user_key = getGet('item_key');
$custom_data = array();

if(getPost('form_submitted') != NULL){   
    foreach($fields_arr as $field){
        $custom_data[$field['FIELD_CODE']] = getPost($field['FIELD_CODE']);
    }
    $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');    
    // 
    if($userObject){
        $userObject['CUSTOM_DATA'] = json_encode($custom_data);
        $userController->user_object->edit($userObject);
        $message = t_('Successfully');
    }else{
        $message = t_('User is not exist in database');
    }
}else{
    $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');
    if(!$userObject){
        $ldapItem = $userController->get_item($user_key); 
        if($ldapItem){
            $userController->user_object->add($configs['base_dn'], $user_key, 'USER', json_encode($ldapItem), '');
            $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER');
        }
    }
    // 
    if($userObject){
        $custom_data = (array)json_decode($userObject['CUSTOM_DATA']);
    }
}
?>

<div class="container-fruid">   
    <form action="/views/user/user-edit.php?item_key=<?php echo $user_key;?>" method="post">
        <h3><?php t_('User:');?> <?php echo $user_key;?></h3>

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">
        <input type="hidden" value="<?php echo $user_key;?>" name="item_code">
    
        <?php for($i=0;$i<count($fields_arr);$i++){
            $field_code = $fields_arr[$i]['FIELD_CODE'];
            $field_name = $fields_arr[$i]['FIELD_NAME'];
            $field_val = getArrayValue($custom_data, $field_code);
        ?>
            <div class="form-group">
                <label for="<?php echo $field_code;?>"><?php t_( $field_name);?></label>
                <input type="text" class="form-control" name="<?php echo $field_code;?>" 
                    id="<?php echo $field_code;?>" value="<?php echo $field_val; ?>">
            </div>  
        <?php } // end for ?> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>  
    </form> 
</div>

<?php
include '../../footer-blank.php';
?>