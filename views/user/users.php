<?php
include '../../header.php'; 
$configs = $_SESSION['config'];
?>

<div class="container-fruid">
    <h2><?php t_('Users');?></h2>
    <?php 
        $userController = new MyUser($configs);
        $arr = $userController->get_list();
        $arrKeys = $userController->get_fields_list();    
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px"><?php t_('No.'); ?></th>  
            <th><?php t_('Key'); ?></th>         
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
                    $user_id_key = $userController->user_id_key;
                    $uid = $arr[$index][$user_id_key][0];
    ?>
        <tr>
            <td><?php echo ($index + 1); ?></td>
            <td><?php echo $uid; ?></td>

            <?php for($i=0;$i<count($arrKeys);$i++){ ?>                 
            <td><?php echo getArrayValue($arr[$index], $arrKeys[$i]); ?></td>  
            <?php } // end for  ?>

            <td>
                <a href="#" data-href="user-detail.php?item_key=<?php echo $uid; ?>" 
                    data-title="<?php t_('User detail');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('View');?>
                </a> | 
                <a href="#" data-href="user-edit.php?item_key=<?php echo $uid; ?>" 
                    data-title="<?php t_('Edit user');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Edit');?>
                </a> | 

                <a href="#" data-href="user-delete.php?item_key=<?php echo $uid; ?>" 
                    data-title="<?php t_('Delete user');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Delete');?>
                </a>
            </td> 
        </tr> 
    <?php
                } // end if
            } // end for
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