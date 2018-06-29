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
    $user_key = getGet('item_key');   
    $userController = new MyUser($configs);
    $ldap_item = $userController->get_item(getGet('item_key')); 

    $key = '';
    $arr = (array)$ldap_item; 
    if($ldap_item){ 
        $key = $arr['distinguishedname'][0];
    }
    
    $message = '';
    $status = false;
    if(getPost('form_submitted') != NULL){   
        $dn = $key;
        $status = $userController->ldap->delete($dn);
        if($status){
            $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER'); 
            if($userObject){
                // update custom data
                $userObject['ACTIVE'] = 0;
                $userController->user_object->edit($userObject);
            }
            $message = 'Successfully';
        }else{
            $message = 'Failed';
        }
    }
?>

<div class="container">
    <form action="/views/user/user-delete.php?item_key=<?php echo $user_key;?>" method="post"> 
        <input type="hidden" value="1" name="form_submitted">

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>   

        <table class="table table-striped"> 
            <tbody> 
                <tr>
                    <td><strong><?php t_('distinguishedname');?></strong></td>
                    <td><?php echoArr($key);?></td> 
                </tr>    
            </tbody>
        </table> 

        <?php if(!$status){?>
        <div class="form-group">
            <button id="deleteBtn" type="button" class="btn btn-primary">Delete</button>
        </div>
        <?php }// end if?>
    </form>
</div>

<script>
    jQuery('#deleteBtn').click(function(){
        if(confirm('<?php t_('Do you want to delete?');?>')){
            jQuery(this).closest('form').submit();
        } 
    });
</script>

<?php
include '../../footer-blank.php';
?>