<?php
include '../../header.php'; 
$configs = $_SESSION['config']; 
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_admin($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<div class="container">
    <h2><?php t_('Groups');?></h2>
    <?php
        $groupController = new MyGroup($configs);
        $arr = $groupController->get_list();
        $arrKeys = $groupController->get_fields_list(); 
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px"><?php t_('No.'); ?></th>             
            <?php for($i=0;$i<count($arrKeys);$i++){ ?>                 
                <th><?php t_($arrKeys[$i]);?></th>   
            <?php } // end for ?>
            <th></th>    
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($arr) > 0){
            for($index = 0; $index < count($arr); $index++) {
                if(isset($arr[$index])){
                    $item_key = $arr[$index]['cn'][0];
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <?php for($i=0;$i<count($arrKeys);$i++){ ?>                 
                <td><?php echo getArrayValue($arr[$index], $arrKeys[$i]); ?></td>  
            <?php } // end for ?>
            <td>
                <?php if($PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){?> 
                <a href="#" data-href="group-change-member.php?item_key=<?php echo $item_key; ?>" 
                    data-title="<?php t_('Members');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Members');?>
                </a>
                <?php  } // end if ?>
            </td>
        </tr> 
    <?php
                } // end if
            }// end for
        } // end if
    ?>
    </tbody>
  </table>
</div>

<?php
include '../../popup.php';
?>

<?php
include '../../footer.php';
?>