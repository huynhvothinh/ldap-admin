<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
$organizationController = new MyOrganization($configs); 
$settingController = new MySetting($configs);

$message = '';  
$arr = $organizationController->get_list_for_suffix();
$accoung_suffix_arr = [];

if(getPost('form_submitted') != NULL){
    $data = getPost('account_suffix');
    if(!$data){
        $data = [];
    }
    $settingController->save_account_suffix(json_encode($data));
    $message = t_value('Successfully');
}else{ 
    $accoung_suffix_arr = $settingController->get_account_suffix();
}
?>

<div class="container-fruid">   
    <form action="/views/settings/account_suffix.php" method="post">
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } // end if ?>        
        <input type="hidden" value="1" name="form_submitted"> 
        
        <div class="form-group">
            <?php for($i=0; $i<count($arr); $i++){ 
                $checked = in_array($arr[$i], $accoung_suffix_arr) ? 'checked' : '';
            ?>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="account_suffix[]" 
                        <?php echo $checked; ?> value="<?php echo $arr[$i]; ?>"> <?php echo $arr[$i]; ?>
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