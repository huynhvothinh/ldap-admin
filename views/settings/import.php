<?php
include '../../header.php'; 
$configs = $_SESSION['config']; 
?>

<?php
    if(!$PERMISSION_CONTROLLER->check_super($USER_PERMISSION_KEY)){
        header("Location: /403.php"); /* Redirect browser */
        exit();
    }      
?>

<div class="container">  
    <h2><?php t_('Import');?></h2> 
    <?php        
        $userController = new MyUser($configs);   
        
        $message = '';
        if(getPost('form_submitted') != NULL){   
            $file = getFile('import');

            if(!$file){
                $message = 'File is required';
            }else{
                if ($file['error'] > 0){
                    $message = 'File is error';
                }
                else{      
                    $arr = array();              
                    $csv = fopen($file['tmp_name'], 'r');
                    while (($line = fgetcsv($csv)) !== FALSE) {
                        array_push($arr, (array)$line);
                    }
                    fclose($csv);

                    // validate
                    $hasUsername=-1;
                    $hasPassword=-1;
                    $hasOU=-1;
                    if(count($arr) <= 1){
                        $message = 'No data to import';
                    }else{
                        for($i=0;$i<count($arr[0]); $i++){
                            if($arr[0][$i] == 'username'){
                                $hasUsername = $i;
                            }else if($arr[0][$i] == 'password'){
                                $hasPassword = $i;
                            }else if($arr[0][$i] == 'ou'){
                                $hasOU = $i;
                            }
                        }
                        if(!($hasPassword >= 0 && $hasPassword >= 0 && $hasOU >= 0)){
                            $message = 'Import need username, password, ou';
                        }else{
                            for($i=1;$i<count($arr); $i++){                                
                                $entry = array();
                                $entry['objectclass'][0] = "top";
                                $entry['objectclass'][1] = "person";
                                $entry['objectclass'][2] = "organizationalPerson";
                                $entry['objectclass'][3] = "user";

                                $user_key = trim($arr[$i][$hasUsername]);
                                $password = trim($arr[$i][$hasPassword]);
                                $dn = sprintf('%s%s,%s',
                                    $configs['admin_account_prefix'],
                                    $user_key,
                                    trim($arr[$i][$hasOU])
                                );
                                try{
                                    echo 'Importing .. '.$user_key.'<br>';
                                    $userController->ldap->add($dn, $entry);                                 
                                    $userController->ldap->change_password($dn, $password);
                                }catch(Exception $e){
                                    //
                                }
                            }
                        }
                    }
                }
            }
        }
    ?>    

    <form action="/views/settings/import.php" method="post" enctype="multipart/form-data">
        
        <?php if($message){?>
        <p class="alert alert-warning"><?php t_($message);?></p>
        <?php } ?>    

        <input type="hidden" value="1" name="form_submitted">
        <div class="form-group">
            <label for="import"><?php t_('Import .csv file(*)');?></label>
            <input type="file" name="import" accept="image/.csv" />
        </div> 

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php t_('Import');?></button>
        </div>  
    </form>  
</div>

<?php
include '../../footer.php';
?>