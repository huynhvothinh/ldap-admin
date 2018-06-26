<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config']; 
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_admin($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<div class="container-fruid">
    <?php        
        $userController = new MyUser($configs);
        $user_key = getGet('item_key');
        $ldap_item = $userController->get_item($user_key);      
    ?>    
    <?php if($ldap_item){ ?>
        <?php
            $arr = (array)$ldap_item;  
            $arrKeys = $userController->get_fields_detail(); 
        ?>

        <h3><?php t_('AD infomation');?></h3>
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
    <?php } // end if ?> 
</div>

<?php
include '../../footer-blank.php';
?>