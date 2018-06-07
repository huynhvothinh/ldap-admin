<?php
include '../../header.php'; 
?>

<div class="container-fruid">
    <h2>Users</h2>
    <?php
        $configs = $_SESSION['config']; 
        $users = ldapGetUsers($configs); 
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px">No.</th>
            <th>uid</th> 
            <th>User name</th> 
            <th></th> 
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($users) > 0){ 
            $arr = sortUsers($users);    
            for($index = 0; $index < count($arr); $index++) {
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <td><?php echo $arr[$index]['uid'][0]?></td>
            <td>
                <a href="#" data-href="user-detail.php?uid=<?php echo $arr[$index]['uid'][0]?>" 
                    data-title="User detail" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
                </a>
            </td> 
            <td>
                <a href="#" data-href="user-edit.php?uid=<?php echo $arr[$index]['uid'][0]?>" 
                    data-title="Edit user" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    Edit
                </a> | 

                <a href="#" data-href="user-delete.php?uid=<?php echo $arr[$index]['uid'][0]?>" 
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