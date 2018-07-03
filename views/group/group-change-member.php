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
$groupController = new MyGroup($configs); 
$user_object_arr = $userController->get_list();
$user_arr = array();

$member_arr = array();
$member_not_user_arr = array();

for($i=0; $i<count($user_object_arr); $i++){
    array_push($user_arr, $user_object_arr[$i]['distinguishedname'][0]);
}
var_dump($user_arr);

$message = '';  

if(getPost('form_submitted') != NULL){   
    $member_arr = getPost('member');    
    // 
    $ldapItem = $groupController->get_item($item_key); 
    if($ldapItem){               

    }
}else{
    $ldapItem = $groupController->get_item($item_key); 
    if($ldapItem){
        if(isset($ldapItem['member'])){
            $member_arr = $ldapItem['member'];
            // last item is count of all item, so we will -1
            for($i=0;$i<count($member_arr)-1; $i++){
                $member_arr[$i] = strtolower($member_arr[$i]);
            }
            echo json_encode($member_arr);
        }
    } 
}
?>

<div class="container">   
    <form action="/views/group/group-change-member.php?item_key=<?php echo $item_key;?>" method="post">
        <h3><?php t_('Group:');?> <?php echo $item_key;?></h3>

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">
        <input type="hidden" value="<?php echo $item_key;?>" name="item_code"> 

        <div class="form-group col-md-6 col-12"  style="min-height:100px; max-height:200px; overflow-y: scroll;">
            <?php  
            for($i=0; $i<count($user_object_arr); $i++){
                $user_key = $user_object_arr[$i]['distinguishedname'][0]; 
                $checked = '';   
                if(in_array(strtolower($user_key), $member_arr)){
                    $checked = 'checked';
                }
            ?> 
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="member[]" <?php echo $checked;?> 
                        value="<?php echo $user_object_arr[$i]['distinguishedname']; ?>"> <?php echo $user_object_arr[$i]['cn'][0]; ?>
                </label>
            </div> 
            <?php } // end for ?>
        </div>  
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>  
    </form> 
</div>

<?php
include '../../footer-blank.php';
?>