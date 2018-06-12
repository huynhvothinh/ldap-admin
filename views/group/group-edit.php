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
        $arrKeys = $groupController->get_fields_edit();
    ?>
    <table class="table table-striped"> 
        <tbody>
        <?php for($i=0;$i<count($arrKeys);$i++){
            $val = getArrayValue($arr, $arrKeys[$i]);
        ?> 
            <tr>
                <td><strong><?php echo $arrKeys[$i];?></strong></td>
                <td><?php echo echoArr($val);?></td> 
            </tr>  
        <?php } // end for ?>
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include '../../footer-blank.php';
?>