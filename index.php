<?php
include 'header.php'; 
?>

<?php
    $configs = $_SESSION['config']; 
    $user = ldapGetUser($configs, $configs['admin_username']);     
    $uid = $configs['admin_username'];  
?>    

<div class="container-fruid">
    <h2>My account</h2>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="user-edit.php?uid=<?php echo $uid;?>" 
                    data-title="Edit profile" data-toggle="modal" data-target="#myModal">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="user-change-pass.php?uid=<?php echo $uid;?>" 
                    data-title="Change password" data-toggle="modal" data-target="#myModal">Change password</a> 
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li> 
        </ul>
    </nav>
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
include 'popup.php';
?>

<?php
include 'footer.php';
?>