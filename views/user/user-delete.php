<?php
include '../../header-blank.php'; 
?>

<div class="container-fruid"> 
    <?php
        $configs = $_SESSION['config']; 
        $user = ldapGetUser($configs, getGet('uid'));       
    ?>    
    <?php if($user){ ?>
    <?php
        $arrFields = ['cn']; // fields for editing
        $arr = json_decode(json_encode($user), true); 
        $arrKeys = array_keys($arr); 
        sort($arrKeys);
    ?>
    <table class="table table-striped"> 
        <tbody>
        <?php for($i=0;$i<count($arrKeys);$i++){
            // check if field is editable
            if(!in_array($arrKeys[$i], $arrFields)){
                continue;
            } // end if check field
            $val = $arr[$arrKeys[$i]]; 
        ?>
        <?php if(is_array($val)){?>
                <tr>
                    <td><strong><?php t_($arrKeys[$i]);?></strong></td>
                    <td><input type="text" name="<?php echo $arrKeys[$i];?>" id="<?php echo $arrKeys[$i];?>" value="<?php echo echoArr($val);?>"></td> 
                </tr>   
            <?php } // end if is array?>
        <?php } // end for each key?> 
        </tbody>
    </table>
    <?php } // end if is user?> 
    
    <div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Save</button> 
    </div>
</div>

<?php
include '../../footer-blank.php';
?>