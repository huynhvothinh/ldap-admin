<?php
    include 'include.php';
?>

<?php
    // connect 
    $ldapconn = ldap_get_connect($configs);
    if($ldapconn) { 
        $ldapbind = ldap_get_bind($ldapconn, $configs);
        // verify binding
        if ($ldapbind) { 
            echo $ldapconn;
        }else{
            echo false;
        }
    }     
?>