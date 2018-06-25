<?php
include '../../header-blank.php'; 
$configs = $_SESSION['config'];         
?>

<?php
$settingController = new MySetting($configs);
$type = getGet('type');
$base_dn = $configs['base_dn'];

$field_code = getPost('field_code'); 
$field_name = getPost('field_name'); 

$message = '';
if(getPost('save')){
    if($field_code && $field_name){
        $field = $settingController->custom_fields->get_item($base_dn, $type, $field_code); 
        if($field){
            $field['FIELD_NAME'] = $field_name;
            $settingController->custom_fields->edit($field);
            $field_code = '';
            $field_name = '';
        }
    }
}else if(getPost('enable')){
    if($field_code){
        $field = $settingController->custom_fields->get_item($base_dn, $type, $field_code); 
        if($field){
            $field['ACTIVE'] = 1;
            $settingController->custom_fields->edit($field);
            $field_code = '';
            $field_name = '';
        }
    }
}else if(getPost('disable')){
    if($field_code){
        $field = $settingController->custom_fields->get_item($base_dn, $type, $field_code);
        if($field){
            $field['ACTIVE'] = 0;
            $settingController->custom_fields->edit($field);
            $field_code = '';
            $field_name = '';
        }
    }
}else if(getPost('delete')){
    if($field_code){
        $field = $settingController->custom_fields->get_item($base_dn, $type, $field_code); 
        if($field){ 
            $settingController->custom_fields->delete($field['FIELD_ID']);
            $field_code = '';
            $field_name = '';
        }
    }
}else if(getPost('add')){
    if($field_code && $field_name){
        $status = $settingController->custom_fields->add($base_dn, $type, $field_code, $field_name, 1); 
        if($status == 1){ 
            $message = 'Successfully';
            $field_code = '';
            $field_name = '';
        }else{
            $message = 'Field code is exist';
        }
    }else{
        $message = 'Field value is required';
    }
}

$arr = $settingController->custom_fields->get_list($base_dn, $type);
?>

<div class="container container-fruid custom-fields">
    <h5><?php t_('Add field');?></h5>
    <form action="/views/settings/custom-fields.php?type=<?php echo $type;?>" method="POST">

        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>

        <div class="form-group">
            <input type="text" name="field_code" class="form-control" placeholder="<?php t_('Field code'); ?>" value="<?php echo $field_code;?>">
            <input type="text" name="field_name" class="form-control" placeholder="<?php t_('Field name'); ?>" value="<?php echo $field_name;?>" >                        
        </div>
        <div class="form-group">
            <input type="submit" name="add" class="btn btn-primary" value="Add">
        </div>
    </form>
    <table class="table table-striped">
        <thead>
        <tr>             
            <th><?php t_('Field code'); ?></th>    
            <th><?php t_('Field name'); ?></th>
        </tr>
        </thead>
        <tbody>    
        <?php if($arr){
            foreach($arr as $item){
        ?>        
        <tr>
            <td><?php echo $item['FIELD_CODE']; ?></td> 
            <td>
                <form action="/views/settings/custom-fields.php?type=<?php echo $type;?>" class="form" method="POST">
                    <input type="hidden" name="field_code" value="<?php echo $item['FIELD_CODE']; ?>">
                    <div class="form-group">
                        <input type="text" name="field_name" <?php echo ($item['ACTIVE'] != 1 ? 'disabled' : '');?> 
                            class="form-control" value="<?php echo $item['FIELD_NAME'];?>" >                        
                    </div>
                    <div class="form-group">

                        <?php if($item['ACTIVE'] == 1){?>
                            <input type="submit" name="save" class="btn btn-primary" value="Save">
                            <input type="submit" name="disable" class="btn btn-warning" value="Disable">
                        <?php }else{?>
                            <input type="submit" name="enable" class="btn btn-primary" value="Enable">
                            <input type="submit" name="delete" class="btn btn-danger" value="Delete">
                        <?php }?>

                    </div>
                </form>
            </td> 
        </tr>   
        <?php } // end if
        } // end for
        ?>
    </tbody>
  </table> 
</div>

<script>
    var stopSubmit = false;
    jQuery(document).ready(function(){
        jQuery('input[name="delete"]').click(function(){ 
            stopSubmit = !confirm('<?php t_('Do you want to delete?');?>'); 
        });
        jQuery('.form').submit(function(e){ 
            if(stopSubmit == true){
                e.preventDefault(0);
            }
            stopSubmit = false;
        });
    });
</script>

<?php
include '../../popup.php'; 
?>

<?php
include '../../footer-blank.php';
?>