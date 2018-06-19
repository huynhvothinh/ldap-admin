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
}

?>