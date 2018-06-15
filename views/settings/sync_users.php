<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php 
$message = '';
if(getPost('form_submitted') != NULL){    
    $userController = new MyUser($configs);
    $arr = $userController->get_list();   
} 
?>

<div class="container-fruid">   
    <form action="/views/settings/account_suffix.php" method="post">
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } // end if ?>        
        <input type="hidden" value="1" name="form_submitted">  

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Sync Users</button>
        </div>  
    </form> 
</div>

<?php
include '../../footer-blank.php';
?>