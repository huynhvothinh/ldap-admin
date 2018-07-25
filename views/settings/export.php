<?php
include '../../header.php'; 
$configs = $_SESSION['config']; 
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<div class="container">  
    <h2><?php t_('Export');?></h2> 

    <form action="/views/settings/export-file.php" method="post" enctype="multipart/form-data">

        <input type="hidden" value="1" name="form_submitted"> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php t_('Export');?></button>
        </div>  
    </form>  
</div>

<?php
include '../../footer.php';
?>