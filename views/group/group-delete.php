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
        $arr = json_decode(json_encode($item), true); 
        $arrKeys = array_keys($arr); 
        sort($arrKeys); 
    ?>
    <table class="table table-striped"> 
        <tbody>
        <?php for($i=0;$i<count($arrKeys);$i++){
            $val = $arr[$arrKeys[$i]]; 
        ?>
        <?php if(is_array($val)){?>
                <tr>
                    <td><strong><?php echo $arrKeys[$i];?></strong></td>
                    <td><?php echo echoArr($val);?></td> 
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