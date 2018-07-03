<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config']; 
$user_key = getGet('item_key');
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
        if($user_key != $configs['admin_username']){
            header("Location: /403.php"); /* Redirect browser */
            exit();
        }
    }      
?>

<div class="container"> 
    <?php        
        $userController = new MyUser($configs);   

        $password = getPost('password');
        $confirm_password = getPost('confirm_password');
        
        $message = '';
        if(getPost('form_submitted') != NULL){   
            if(!$password){
                $message = 'Password is required';
            }else  if($password != $confirm_password){
                $message = 'Confirm password is matched password';
            }else{
                $item = $userController->get_item($user_key);
                if($item){
                    $status = $userController->ldap->change_password($item['distinguishedname'][0], $password);
                    if($status){
                        $message = 'Successfully';
                    }else{
                        $message = 'Failed';
                    }
                }else{
                    $message = 'User is not exist';
                }
            }
        }
    ?>     

    <form action="/views/user/user-change-pass.php?item_key=<?php echo $user_key;?>" method="post">
        <h3><?php t_('User:');?> <?php echo $user_key;?></h3>
        
        <p class="alert alert-info">
            <?php t_('Password length >= 8');?>
            <br>
            <?php t_('Password need meet AD policy');?>
        </p>
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">
        <input type="hidden" value="<?php echo $user_key;?>" name="user_key">
        
        <div class="form-group">
            <label for="password"><?php t_('Password (*)');?></label>
            <input type="password" class="form-control" name="password" 
                id="password" value="<?php echo $password; ?>">
        </div> 
        <div class="form-group">
            <label for="confirm_password"><?php t_('Confirm password (*)');?></label>
            <input type="password" class="form-control" name="confirm_password" 
                id="confirm_password" value="<?php echo $confirm_password; ?>">
        </div> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>  
    </form>  
</div>

<?php
include '../../footer-blank.php';
?>