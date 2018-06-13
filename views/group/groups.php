<?php
include '../../header.php'; 
?>

<div class="container-fruid">
    <h2><?php t_('Groups');?></h2>
    <?php
        $configs = $_SESSION['config']; 
        $groupController = new MyGroup($configs);
        $arr = $groupController->get_list();
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px">No.</th>
            <th><?php t_('Key');?></th> 
            <th><?php t_('Group name');?></th> 
            <th></th> 
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($arr) > 0){
            for($index = 0; $index < count($arr); $index++) {
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <td><?php echo $arr[$index]['cn'][0]?></td>
            <td>
                <a href="#" data-href="group-detail.php?item_key=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="<?php t_('Group detail');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
                </a>
            </td> 
            <td>
                <a href="#" data-href="group-edit.php?item_key=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="<?php t_('Group edit');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Edit');?>
                </a> | 
                <a href="#" data-href="group-delete.php?item_key=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="<?php t_('Group delete');?>" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php t_('Delete');?>
                </a>
            </td> 
        </tr> 
    <?php
            }
        }
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