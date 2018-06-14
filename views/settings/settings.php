<?php
include '../../header.php'; 
$configs = $_SESSION['config']; 
?>

<div class="container-fruid">
    <h2><?php t_('Settings');?></h2>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link group-detail-toggle" href="#" data-href="/views/settings/account_suffix.php"
                    data-title="<?php t_('Account Suffix');?>" data-toggle="modal" data-target="#myModal"><?php t_('Account Suffix');?></a>
            </li>  
        </ul>
    </nav>
    <?php
        $userController = new MyUser($configs);
        $arr = $userController->get_list();
    ?>
    <table class="table table-striped">
        <thead> 
        </thead>
        <tbody> 
        </tbody>
  </table>
</div>

<?php
include '../../popup.php'; 
?>

<?php
include '../../footer.php';
?>