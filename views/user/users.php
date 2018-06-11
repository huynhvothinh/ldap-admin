<?php
include '../../header.php'; 
?>

<div class="container-fruid">
    <h2>Users</h2>
    <?php
        $configs = $_SESSION['config']; 
        $userController = new MyUser($configs);
        $arr = $userController->get_list();
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px">No.</th>
            <th>Key</th> 
            <th>User name</th> 
            <th></th> 
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($arr) > 0){  
            for($index = 0; $index < count($arr); $index++) {
                if(!array_key_exists($index, $arr))
                    continue; 
                    
                $user_id_key = $userController->user_id_key;
                $uid = $arr[$index][$user_id_key][0];
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <td><?php echo $uid; ?></td>
            <td>
                <a href="#" data-href="user-detail.php?item_key=<?php echo $uid; ?>" 
                    data-title="User detail" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
                </a>
            </td> 
            <td>
                <a href="#" data-href="user-edit.php?item_key=<?php echo $uid; ?>" 
                    data-title="Edit user" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    Edit
                </a> | 

                <a href="#" data-href="user-delete.php?item_key=<?php echo $uid; ?>" 
                    data-title="Delete user" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    Delete
                </a>
            </td> 
        </tr> 
    <?php
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