<?php
include '../../header-blank.php'; 
?>

<div class="container-fruid">
    <?php
        $configs = $_SESSION['config']; 
        
        $userController = new MyUser($configs);
        $item = $userController->get_item(getGet('item_key'));      
    ?>    
    <?php if($item){ ?>
    <?php
        $arr = (array)$item; 
    ?>
    <table class="table table-striped"> 
        <tbody> 
            <tr>
                <td><strong><?php t_( $userController->user_id_key);?></strong></td>
                <td><?php echoArr($arr[$userController->user_id_key]);?></td> 
            </tr>    
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include '../../footer-blank.php';
?>