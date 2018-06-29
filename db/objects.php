<?php
class MyObjectsDB{
    public $db = NULL;     

    function __construct(){ 
        $this->db = new MyDB(
            MyConfig::$db_configs['servername'],
            MyConfig::$db_configs['username'],
            MyConfig::$db_configs['password'],
            MyConfig::$db_configs['database']
        ); 
    }

    function get_item($base_dn, $code, $type){ 
        $arr = [];

        if($this->db->connect()){
            
            $sql = "call objects_get('$base_dn', '$code', '$type');";   
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

    function add($base_dn, $code, $type, $ad_data, $custom_data){  
        $arr = [];

        if($this->db->connect()){            
            $sql = "call objects_add('$base_dn', '$code', '$type', '$ad_data', '$custom_data');"; 
            $result = mysqli_query($this->db->conn, $sql);  

            while($row = mysqli_fetch_array($result)){ 
                array_push($arr, $row);
            } 

            $this->db->conn->close();
        }
        
        if(count($arr) > 0)
            return $arr[0]['STATUS'];
        else
            return NULL;
    }

    function edit($item){
        if($this->db->connect()){
            if($item){ 
                $sql = "call objects_edit('%s','%s', '%s', %s);";
                $sql = sprintf($sql, 
                    $item['OBJECT_ID'],
                    $item['AD_DATA'],
                    $item['CUSTOM_DATA'],
                    $item['ACTIVE']
                );
                
                mysqli_query($this->db->conn, $sql);  

                $this->db->conn->close();
            }
        }
    }
}
?>