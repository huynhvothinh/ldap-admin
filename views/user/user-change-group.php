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
$userItem = $userController->get_item($item_key);

$groupController = new MyGroup($configs);
$groupArr = $groupController->get_list();

$memberOfArr = array();
if($userItem && isset($userItem['memberof'])){ 
    for($i=0;$i<count($userItem['memberof']) - 1;$i++){
        array_push($memberOfArr, $userItem['memberof'][$i]);
    }
}

$message = '';

if(getPost('add') && getPost('new_member_of')){
    $entry = array();
    $entry['member'] = $userItem['distinguishedname'][0];

    $new_member_of = getPost('new_member_of');
    if($groupController->ldap->add_field($new_member_of, $entry)){
        $message = 'Successfully';
        array_push($memberOfArr, $new_member_of);
    }else{
        $message = 'Failed';
    }
}else if(getPost('remove') && getPost('del_member_of')){
    $entry = array();
    $entry['member'] = $userItem['distinguishedname'][0];

    $del_member_of = getPost('del_member_of');
    if($groupController->ldap->del_field($del_member_of, $entry)){
        $message = 'Successfully';

        for($i=0;$i<count($memberOfArr);$i++){
            if($del_member_of == $memberOfArr[$i]){
                unset($memberOfArr[$i]);
            }
        } 
    }else{
        $message = 'Failed';
    }
}
?>

<div class="container">
    <h3><?php t_('User');?> <?php echo $userItem['cn'][0];?></h3>
    <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
    <?php } //end if?>

    <form action="/views/user/user-change-group.php?item_key=<?php echo $item_key;?>" method="post">
        <div class="form-group">
            <select name="new_member_of">    
            <?php
                for($index = 0; $index < count($groupArr); $index++) {
                    if(isset($groupArr[$index]) && !in_array($groupArr[$index]['distinguishedname'][0], $memberOfArr)){  
                        $group_key = $groupArr[$index]['distinguishedname'][0];
                    ?>
                        <option value="<?php echo $group_key;?>">
                            <?php echo $group_key;?>
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
            for($index = 0; $index < count($groupArr); $index++) {
                if(isset($groupArr[$index]) && in_array($groupArr[$index]['distinguishedname'][0], $memberOfArr)){  
                    $uid = $groupArr[$index]['cn'][0];
                    $group_key = $groupArr[$index]['distinguishedname'][0];
        ?>
            <tr>
                <td><?php echo ($indexTotal + 1); ?></td>
                <td><?php echo $uid; ?></td>
                <td><?php echo $group_key; ?></td>

                <td>      
                    <form action="/views/user/user-change-group.php?item_key=<?php echo $item_key;?>" method="post">  
                        <input type="hidden" name="del_member_of" value="<?php echo $group_key; ?>">
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