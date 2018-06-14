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
    <?php
        $arr = (array)$item;  
        $arrKeys = $userController->get_fields_detail(); 
    ?>
    <table class="table table-striped"> 
        <tbody>
        <?php for($i=0;$i<count($arrKeys);$i++){
            $val = getArrayValue($arr, $arrKeys[$i]);
        ?> 
            <tr>
                <td><strong><?php t_( $arrKeys[$i]);?></strong></td>
                <td><?php echoArr($val);?></td> 
            </tr>    
        <?php } // end for ?>
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include '../../footer-blank.php';
?>