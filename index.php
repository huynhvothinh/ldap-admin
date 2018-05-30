<?php
include 'header.php'; 
?>

<div class="container-fruid">
    <h2>My account</h2>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Change password</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li> 
        </ul>
    </nav>
    <?php
        $configs = $_SESSION['config']; 
        $user = ldapGetUser($configs, $configs['admin_username']);       
    ?>    
    <?php if($user){ ?>
    <?php
        $arr = json_decode(json_encode($user), true); 
        $arrKeys = array_keys($arr); 
    ?>
    <table class="table table-striped"> 
        <tbody>
        <?php for($i=0;$i<count($arrKeys);$i++){
            $val = $arr[$arrKeys[$i]]; 
        ?>
        <?php if(is_array($val)){?>
                <tr>
                    <td><strong><?php echo $arrKeys[$i];?></strong></td>
                    <td><?php echo echoArr($val);?></td> 
                </tr>   
            <?php } // end if?>
        <?php } // end for ?>
        </tbody>
    </table>
    <?php } // end if?> 
</div>

<?php
include 'footer.php';
?>