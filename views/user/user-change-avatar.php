<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config']; 
?>

<div class="container-fruid"> 
    <?php
        $userController = new MyUser($configs);
        $item = $userController->get_item(getGet('item_key'));        
    ?>    
    <?php if($item){ ?> 
    <table class="table table-striped"> 
        <tbody> 
            <tr>
                <td><strong><?php t_('Password');?></strong></td>
                <td><input type="password" name="password" id="password" value=""></td> 
            </tr>  
            <tr>
                <td><strong><?php t_('Confirm password');?></strong></td>
                <td><input type="password" name="confirm_password" id="confirm_password" value=""></td> 
            </tr>  
        </tbody>
    </table>
    <?php } // end if?> 
    
    <div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Save</button> 
    </div>
</div>

<?php
include '../../footer-blank.php';
?>