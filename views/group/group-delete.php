<?php
include '../../header-blank.php'; 
?>

<div class="container-fruid">
    <?php
        $configs = $_SESSION['config'];
        $groupController = new MyGroup($configs); 
        $item = $groupController->get_item(getGet('item_key'));       
    ?>    
    <?php if($item){ ?>
    <?php
        $arr = (array)$item; 
    ?>
    <table class="table table-striped"> 
        <tbody> 
            <tr>
                <td><strong><?php t_('cn');?></strong></td>
                <td><?php echo echoArr($arr['cn']);?></td> 
            </tr>    
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include '../../footer-blank.php';
?>