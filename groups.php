<?php
include 'header.php'; 
?>

<div class="container-fruid">
    <h2>Groups</h2>
    <?php
        $configs = $_SESSION['config']; 
        $groups = ldapGetGroups($configs); 
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px">No.</th>
            <th>ou</th> 
            <th>Group name</th> 
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($groups) > 0){
            $arr = sortGroups($groups);
            for($index = 0; $index < count($arr); $index++) {
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <td><?php echo $arr[$index]['ou'][0]?></td>
            <td>
                <a href="#" data-href="group-detail.php?ou=<?php echo $arr[$index]['ou'][0]?>" 
                    data-title="Group detail" data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
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
include 'popup.php';
?>

<?php
include 'footer.php';
?>