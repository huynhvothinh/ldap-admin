<?php
class MyDB{
    private $servername = '';
    private $username = '';
    private $password = '';
    private $database = ''; 
    public $conn = NULL;

    function __construct($servername, $username, $password, $database){
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database; 
    }

    function connect(){
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            return false;
        }else{
            return true;
        }
    }

    function loadDBConfigs($default_configs){ 
        if($this->connect()){
            $sql = "call basedn_list()";
            $result = mysqli_query($this->conn, $sql);  

            while($row = mysqli_fetch_array($result)){
                $default_configs['domain_controllers'] = $row['HOST'];
                $default_configs['base_dn'] = $row['BASEDN_CODE'];
                $default_configs['port'] = $row['PORT'];
                $default_configs['admin_account_prefix'] = $row['ACCOUNT_PREFIX'];
                $default_configs['admin_account_suffix'] = $row['ACCOUNT_SUFFIX'];
                $default_configs['admin_account_suffix_arr'] = json_decode($row['ACCOUNT_SUFFIX_ARR']);
                $default_configs['use_ssl'] = $row['SSL'];
                $default_configs['user_filter'] = $row['USER_FILTER'];
                $default_configs['group_filter'] = $row['GROUP_FILTER'];
                $default_configs['organization_filter'] = $row['ORGANIZATION_FILTER'];

                break;
            } 

            $this->conn->close();
        }
        
        return $default_configs;
    }
}

?>