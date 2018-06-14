<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
$userController = new MyUser($configs);
$arrKeys = $userController->get_fields_edit(); 

$message = '';
$itemCode = '';
$arr = array();
if(getPost('form_submitted') != NULL){ 
    // the key of item
    $itemCode = getPost('item_code');

    // fields of updating
    $value = NULL;  
    for($i=0;$i<count($arrKeys);$i++){ 
        $value = getPost($arrKeys[$i]);
        if($value != NULL){
            $arr[$arrKeys[$i]][0] = $value;
        }
    }
    // do updating
    $status = $userController->update_item($itemCode, $arr); 
    if($status){        
        $message = "Update uccessfully";
    }else{
        $message = "Update failed";
    }
}else{
    $item = $userController->get_item(getGet('item_key')); 
    if($item){
        $arr = (array)$item;
        $itemCode = $userController->get_object_dn($item);
    }
}
?>

<div class="container-fruid">   
    <form action="/views/user/user-edit.php" method="post">
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>        
        <input type="hidden" value="1" name="form_submitted">
        <input type="hidden" value="<?php echo $itemCode;?>" name="item_code">
    
        <?php for($i=0;$i<count($arrKeys);$i++){
            $key = $arrKeys[$i];
            $val = getArrayValue($arr, $key);
        ?>
            <div class="form-group">
                <label for="<?php echo $key;?>"><?php t_( $key);?></label>
                <input type="text" class="form-control" name="<?php echo $key;?>" 
                    id="<?php echo $key;?>" value="<?php echo $val; ?>">
            </div>  
        <?php } // end for ?> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>  
    </form> 
</div>

<?php
include '../../footer-blank.php';
?>