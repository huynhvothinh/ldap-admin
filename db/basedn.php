<?php
class MyBaseDNDB{
    public $db = NULL;     

    function __construct(){ 
        $this->db = new MyDB(
            MyConfig::$db_configs['servername'],
            MyConfig::$db_configs['username'],
            MyConfig::$db_configs['password'],
            MyConfig::$db_configs['database']
        ); 
    } 

    function get_list($active){ 
        $arr = [];

        if($this->db->connect()){
            $sql = "call basedn_list(1)";
            if(!$active){
                $sql =  "call basedn_list(0)";               
            }

            $result = mysqli_query($this->db->conn, $sql);  

            while($row = mysqli_fetch_array($result)){ 
                array_push($arr, $row);
            } 

            $this->db->conn->close();
        }
        
        return $arr;
    }

    function get_item($basedn){ 
        $arr = [];

        if($this->db->connect()){
            
            $basedn = mysqli_real_escape_string($this->db->conn,$basedn);
            $sql = "call basedn_get('$basedn');";  

            $result = mysqli_query($this->db->conn, $sql);  

            while($row = mysqli_fetch_array($result)){ 
                array_push($arr, $row);
            } 

            $this->db->conn->close();
        }
        
        if(count($arr) > 0)
            return $arr[0];
        else
            return NULL;
    }

    function add($basedn){  
        if($this->db->connect()){            
            $sql = "call basedn_add('%s');";
            $sql = sprintf($sql, $basedn);
            mysqli_query($this->db->conn, $sql);  
            $this->db->conn->close();
        }
    }

    function edit($item){
        if($this->db->connect()){
            if($item){ 
                $sql = "call basedn_edit('%s','%s','%s','%s','%s',%d,%d,%d,'%s','%s','%s');";
                $sql = sprintf($sql, 
                    $item['BASEDN_CODE'],
                    $item['HOST'],
                    $item['ACCOUNT_PREFIX'],
                    $item['ACCOUNT_SUFFIX'],
                    $item['ACCOUNT_SUFFIX_ARR'],
                    $item['ACTIVE'],
                    $item['SSL'],
                    $item['PORT'],
                    $item['USER_FILTER'],
                    $item['GROUP_FILTER'],
                    $item['ORGANIZATION_FILTER']
                );
                
                mysqli_query($this->db->conn, $sql);  

                $this->db->conn->close();
            }
        }
    }
}

?>