<?php
include 'header.php'; 
?>

<?php
    $configs = $_SESSION['config']; 

    $userController = new MyUser($configs); 
    $user_key = $configs['admin_username'];
    $ldap_item = $userController->get_item($user_key);    
?>    

<div class="container-fruid">
    <h2>My account</h2>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-edit.php?item_key=<?php echo $user_key;?>" 
                    data-title="Edit profile" data-toggle="modal" data-target="#myModal">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-change-avatar.php?item_key=<?php echo $user_key;?>" 
                    data-title="Change avatar" data-toggle="modal" data-target="#myModal">Change avatar</a> 
            </li> 
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-change-pass.php?item_key=<?php echo $user_key;?>" 
                    data-title="Change password" data-toggle="modal" data-target="#myModal">Change password</a> 
            </li>  
        </ul>
    </nav>
    <?php if($ldap_item){ ?>
        <?php
            $arr = (array)$ldap_item; 
            $arrKeys = $userController->get_fields_detail();
        ?>

        <h3><?php t_('AD infomation');?></h3>
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
                    <td><strong><?php t_($arrKeys[$i]);?></strong></td>
                    <td><?php echo echoArr($val);?></td> 
                </tr>    
            <?php } // end for ?>
            </tbody>
        </table>
        
        <?php
            $custom_data = array();
            $fields_arr = $userController->get_custom_fields(); 
            $userObject = $userController->user_object->get_item($configs['base_dn'], $user_key, 'USER'); 
        ?>
        <?php 
            if($userObject){         
                $custom_data = (array)json_decode($userObject['CUSTOM_DATA']); 
            } // end if 
        ?>
            <h3><?php t_('Custom infomation');?></h3>
            <table class="table table-striped"> 
                <tbody>
                <?php for($i=0;$i<count($fields_arr);$i++){
                    $field_code = $fields_arr[$i]['FIELD_CODE'];
                    $field_name = $fields_arr[$i]['FIELD_NAME'];
                    $field_val = getArrayValue($custom_data, $field_code); 
                ?> 
                    <tr>
                        <td><strong><?php t_( $field_name);?></strong></td>
                        <td><?php echo $field_val;?></td> 
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