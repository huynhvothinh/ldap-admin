<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];
$item_key = getGet('item_key');
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<?php 
$userController = new MyUser($configs);
$userArr = $userController->get_list();     

$groupController = new MyGroup($configs);
$groupItem = $groupController->get_item($item_key);

$memberArr = array();
if($groupItem && isset($groupItem['member'])){ 
    for($i=0;$i<count($groupItem['member']) - 1;$i++){
        array_push($memberArr, $groupItem['member'][$i]);
    }
}

$message = '';

if(getPost('add') && getPost('new_member')){
    $entry = array();
    $new_member = getPost('new_member');
    $entry['member'] = $new_member;
    if($groupController->ldap->add_field($groupItem['distinguishedname'][0], $entry)){
        $message = 'Successfully';
        array_push($memberArr, $new_member);
    }else{
        $message = 'Failed';
    }
}else if(getPost('remove') && getPost('del_member')){
    $entry = array();
    $del_member = getPost('del_member');
    $entry['member'] = $del_member;
    if($groupController->ldap->del_field($groupItem['distinguishedname'][0], $entry)){
        $message = 'Successfully';

        for($i=0;$i<count($memberArr);$i++){
            if($del_member == $memberArr[$i]){
                unset($memberArr[$i]);
            }
        } 
    }else{
        $message = 'Failed';
    }
}
?>

<div class="container">
    <h3><?php t_('Group');?> <?php echo $groupItem['cn'][0];?></h3>
    <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
    <?php } //end if?>

    <form action="/views/group/group-change-member.php?item_key=<?php echo $item_key;?>" method="post">
        <div class="form-group">
            <select name="new_member">    
            <?php
                for($index = 0; $index < count($userArr); $index++) {
                    if(isset($userArr[$index]) && !in_array($userArr[$index]['distinguishedname'][0], $memberArr)){  
                    ?>
                        <option value="<?php echo $userArr[$index]['distinguishedname'][0];?>">
                            <?php echo $userArr[$index]['distinguishedname'][0];?>
                        </option>
                    <?php
                    }
                }
            ?>
            </select>
            <input type="submit" name="add" class="btn btn-primary" value="Add">   
        </div>
    </form>

    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px"><?php t_('No.'); ?></th>  
            <th><?php t_('Key'); ?></th>   
            <th><?php t_('distinguishedname'); ?></th>   
            <th></th>   
        </tr>
        </thead>
        <tbody>
        <?php  
            $indexTotal = 0;
            for($index = 0; $index < count($userArr); $index++) {
                if(isset($userArr[$index]) && in_array($userArr[$index]['distinguishedname'][0], $memberArr)){                     
                    $user_id_key = $userController->user_id_key;
                    $uid = $userArr[$index][$user_id_key][0];
                    $user_key = $userArr[$index]['distinguishedname'][0];
        ?>
            <tr>
                <td><?php echo ($indexTotal + 1); ?></td>
                <td><?php echo $uid; ?></td>
                <td><?php echo $user_key; ?></td>

                <td>      
                    <form action="/views/group/group-change-member.php?item_key=<?php echo $item_key;?>" method="post">  
                        <input type="hidden" name="del_member" value="<?php echo $user_key; ?>">
                        <input type="submit" name="remove" class="btn btn-danger" value="Remove">       
                    </form>
                </td> 
            </tr> 
        <?php
                } // end if
            } // end for 
        ?>
        </tbody>
    </table>
</div>

<?php
include '../../popup.php'; 
?>

<script>
    jQuery(document).ready(function(){
        jQuery('.group-detail-toggle').click(function(){  
            var url = jQuery(this).attr('data-href');
            if(url.indexOf('user-edit') != -1 || url.indexOf('user-delete') != -1 || url.indexOf('user-add') != -1){                 
                jQuery('.close-modal').attr('data-reload', '1');
            }
        });    
        
        jQuery('input[name="remove"]').click(function(){ 
            stopSubmit = !confirm('<?php t_('Do you want to remove?');?>'); 
        });        
    });
</script>

<?php
include '../../footer-blank.php';
?>