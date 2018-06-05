<?php
include 'header-blank.php'; 
?>

<div class="container-fruid">
    <?php
        $configs = $_SESSION['config']; 
        $user = ldapGetUser($configs, getGet('uid'));       
    ?>    
    <?php if($user){ ?>
    <?php
        $arr = json_decode(json_encode($user), true); 
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
                    <td><strong><?php t_( $arrKeys[$i]);?></strong></td>
                    <td><?php echo echoArr($val);?></td> 
                </tr>   
            <?php } // end if?>
        <?php } // end for ?>
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include 'footer-blank.php';
?>