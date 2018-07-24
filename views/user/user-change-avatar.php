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
        
        $message = '';
        $avatarFile = '';
        if(getPost('form_submitted') != NULL){   
            $avatar = getFile('avatar');

            if(!$avatar){
                $message = 'Avatar is required';
            }else{
                if ($avatar['error'] > 0){
                    $message = 'File is error';
                }
                else{
                    // Upload file
                    $file = '../../uploads/avatar/'.$avatar['name'];
                    move_uploaded_file($avatar['tmp_name'], $file);
                    convertImage($file, '../../uploads/avatar/'.$user_key.'.jpg', 100);
                    unlink($file);
                    $avatarFile = '/uploads/avatar/'.$user_key.'.jpg';
                    $avatarFile .= '?t='.time();
                    $message = 'File is uploaded';
                }
            }
        }
    ?>    

    <form action="/views/user/user-change-avatar.php?item_key=<?php echo $user_key;?>" method="post" enctype="multipart/form-data">
        
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">
        <input type="hidden" value="<?php echo $user_key;?>" name="user_key">
        <?php 
            if($avatarFile){
                ?>
                <img src="<?php echo $avatarFile; ?>" style="max-height: 200px;">
                <?php
            }
        ?>
        <div class="form-group">
            <label for="avatar"><?php t_('Upload avatar (*)');?></label>
            <input type="file" name="avatar" accept="image/*" />
        </div> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php t_('Save');?></button>
        </div>  
    </form>  
</div>

<?php
include '../../footer-blank.php';
?>