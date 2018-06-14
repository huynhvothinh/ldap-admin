<?php
include '../../header.php'; 
$configs = $_SESSION['config']; 
?>

<div class="container-fruid">
    <?php        
        $organizationController = new MyOrganization($configs);
        $arr = $organizationController->get_list();   
        $arrKeys = $organizationController->get_fields_list();    
    ?> 
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width:30px"><?php t_('No.'); ?></th>             
            <?php for($i=0;$i<count($arrKeys);$i++){ ?>                 
                <th><?php t_($arrKeys[$i]);?></th>   
            <?php } // end for ?>
        </tr>
        </thead>
        <tbody>
    <?php 
        if(count($arr) > 0){
            for($index = 0; $index < count($arr); $index++) {
                if(isset($arr[$index])){
    ?>
        <tr>
            <td><?php echo ($index + 1)?></td>
            <?php for($i=0;$i<count($arrKeys);$i++){ ?>                 
                <td><?php echo getArrayValue($arr[$index], $arrKeys[$i]); ?></td>  
            <?php } // end for  ?>
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
include '../../footer.php';
?>