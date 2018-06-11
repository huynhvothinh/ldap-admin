<?php
include '../../header.php'; 
?>

<div class="container-fruid">
    <h2>Groups</h2>
    <?php
        $configs = $_SESSION['config']; 
        $groupController = new MyGroup($configs);
        $arr = $groupController->get_list();
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px">No.</th>
            <th>Key</th> 
            <th>Group name</th> 
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
                    data-title="Group detail" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
                </a>
            </td> 
            <td>
                <a href="#" data-href="group-edit.php?item_key=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="Group edit" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    Edit
                </a> | 
                <a href="#" data-href="group-delete.php?item_key=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="Group delete" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    Delete
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