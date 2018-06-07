<?php
include '../../header.php'; 
?>

<div class="container-fruid">
    <h2>Roles</h2>
    <?php
        $configs = $_SESSION['config']; 
        $roles = ldapGetRoles($configs); 
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px">No.</th>
            <th>Description</th> 
            <th>Role name</th> 
            <th></th> 
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($roles) > 0){
            $arr = sortroles($roles);
            for($index = 0; $index < count($arr); $index++) {
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <td><?php echo $arr[$index]['description'][0]?></td>
            <td>
                <a href="#" data-href="role-detail.php?cn=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="Role detail" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
                </a>
            </td> 
            <td>
                <a href="#" data-href="role-detail.php?cn=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="Role edit" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    Edit
                </a> | 
                <a href="#" data-href="role-detail.php?cn=<?php echo $arr[$index]['cn'][0]?>" 
                    data-title="Role delete" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
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