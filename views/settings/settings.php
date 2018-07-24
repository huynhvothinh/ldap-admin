<?php
include '../../header.php'; 
$configs = $_SESSION['config'];         
?>

<div class="container settings">
    <h2><?php t_('Settings');?></h2> 
    
    <table class="table table-striped">
        <tbody> 
        <tr>
            <td><?php t_('Configs');?></td> 
            <td>
                <a href="#" data-href="configs.php" data-title="<?php t_('Configs');?>" 
                    data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Change');?>
                </a>
            </td> 
        </tr>    
        <tr>
            <td><?php t_('User fields');?></td> 
            <td>
                <a href="#" data-href="custom-fields.php?type=user" data-title="<?php t_('User fields');?>" 
                    data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Change');?>
                </a>
            </td> 
        </tr>   
        <tr>
            <td><?php t_('Permissions');?></td> 
            <td>
                <a href="#" data-href="permissions.php" data-title="<?php t_('Permissions');?>" 
                    data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Change');?>
                </a>
            </td> 
        </tr> 
    </tbody>
  </table> 
</div>

<?php
include '../../popup.php'; 
?>

<?php
include '../../footer.php';
?>