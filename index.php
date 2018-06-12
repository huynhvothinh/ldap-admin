<?php
include 'header.php'; 
?>

<?php
    $configs = $_SESSION['config']; 

    $userController = new MyUser($configs); 
    $user = $userController->get_item($configs['admin_username']);     
    $uid = $configs['admin_username'];  
?>    

<div class="container-fruid">
    <h2>My account</h2>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-edit.php?item_key=<?php echo $uid;?>" 
                    data-title="Edit profile" data-toggle="modal" data-target="#myModal">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-change-avatar.php?item_key=<?php echo $uid;?>" 
                    data-title="Change avatar" data-toggle="modal" data-target="#myModal">Change avatar</a> 
            </li> 
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-change-pass.php?item_key=<?php echo $uid;?>" 
                    data-title="Change password" data-toggle="modal" data-target="#myModal">Change password</a> 
            </li>  
        </ul>
    </nav>
    <?php if($user){ ?>
    <?php
        $arr = (array)$user; 
        $arrKeys = $userController->get_fields_detail();
    ?>
    <table class="table table-striped"> 
        <tbody>
            <tr>
                <td><strong><?php t_('Avatar');?></strong></td>
                <td><?php if(isset($arr['thumbnailphoto'][0])){
                    echo $arr['thumbnailphoto'][0];
                }?></td> 
            </tr>   
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
include 'popup.php';
?>

<?php
include 'footer.php';
?>