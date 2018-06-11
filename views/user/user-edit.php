<?php
include '../../header-blank.php'; 
?>

<div class="container-fruid">
    <?php
        $userController = new MyUser($configs);

        $configs = $_SESSION['config']; 
        $item = $userController->get_item(getGet('item_key'));      
    ?>    
    <?php if($item){ ?>
    <?php
        $arr = (array)$item;
        $arrKeys = array_keys($arr);  
    ?>
    <table class="table table-striped"> 
        <tbody>
        <?php for($i=0;$i<count($arrKeys);$i++){
            $val = $arr[$arrKeys[$i]]; 
        ?>
        <?php if(is_array($val)){?>
                <tr>
                    <td><strong><?php t_( $arrKeys[$i]);?></strong></td>
                    <td><?php echoArr($val);?></td> 
                </tr>   
            <?php } // end if?>
        <?php } // end for ?>
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include '../../footer-blank.php';
?>