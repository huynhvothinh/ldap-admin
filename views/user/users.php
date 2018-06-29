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
    <h2><?php t_('Users');?></h2>
    <?php 
        $userController = new MyUser($configs);
        $arr = $userController->get_list(); 
        $arrKeys = $userController->get_fields_list();    
    ?>

    <?php if($PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){?>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link group-detail-toggle" href="#" data-href="/views/user/user-add.php" 
                        data-title="<?php t_('Add');?>" data-toggle="modal" data-target="#myModal"><?php t_('Add');?></a>
                </li>   
            </ul>
        </nav>
    <?php } // end if?>

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
                </a>
                
                <?php if($PERMISSION_CONTROLLER->check_admin($USER_PERMISSION_KEY)){?>
                | 
                <a href="#" data-href="user-edit.php?item_key=<?php echo $uid; ?>" 
                    data-title="<?php t_('Edit user');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Edit');?>
                </a> 
                <?php  } // end if ?>

                <?php if($PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){?>
                |
                <a href="#" data-href="user-change-pass.php?item_key=<?php echo $uid; ?>" 
                    data-title="<?php t_('Password');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Password');?>
                </a>
                |
                <a href="#" data-href="user-delete.php?item_key=<?php echo $uid; ?>" 
                    data-title="<?php t_('Delete user');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Delete');?>
                </a>
                <?php  } // end if ?>
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

<script>
    jQuery(document).ready(function(){
        jQuery('.group-detail-toggle').click(function(){  
            var url = jQuery(this).attr('data-href');
            if(url.indexOf('user-edit') != -1 || url.indexOf('user-delete') != -1 || url.indexOf('user-add') != -1){                 
                jQuery('.close-modal').attr('data-reload', '1');
            }
        });            
    });
</script>

<?php
include '../../footer.php';
?>