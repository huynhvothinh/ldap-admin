<?php
include 'header.php';
include 'config.php';
include 'utils.php';
?>

<div class="container-fruid">
    <h2>My account</h2>
    <?php
        $configs = $_SESSION['config']; 
        $user = ldapGetUser($configs, $configs['admin_username']);       
    ?>    
    <?php if($user){ ?>
    <?php
        $arr = json_decode(json_encode($user), true); 
        $arrKeys = array_keys($arr); 
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
include 'footer.php';
?>