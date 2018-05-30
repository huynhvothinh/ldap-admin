<?php
include 'header.php';
include 'config.php';
include 'utils.php';
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
                    data-toggle="modal" data-target="#myModal" class="group-detail-toggle">    
                    <?php echo $arr[$index]['cn'][0]?>
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

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"> 
        <h2>User detail</h2>    
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <iframe id="group-detail-iframe"></iframe>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
    jQuery(document).ready(function(){ 
        jQuery('.group-detail-toggle').click(function(){  
            var url = jQuery(this).attr('data-href');
            jQuery('#group-detail-iframe').attr('src', url);
        })
    });
</script>

<?php
include 'footer.php';
?>