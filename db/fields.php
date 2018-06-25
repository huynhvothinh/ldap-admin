<?php
class MyFieldsDB{
    public $db = NULL;     

    function __construct(){ 
        $this->db = new MyDB(
            MyConfig::$db_configs['servername'],
            MyConfig::$db_configs['username'],
            MyConfig::$db_configs['password'],
            MyConfig::$db_configs['database']
        ); 
    }

    function get_list($base_dn, $type){ 
        $arr = [];

        if($this->db->connect()){
            $sql = "call fields_list('$base_dn','$type')";
            $result = mysqli_query($this->db->conn, $sql);  

            while($row = mysqli_fetch_array($result)){ 
                array_push($arr, $row);
            } 

            $this->db->conn->close();
        }
        
        return $arr;
    }

    function get_item($base_dn, $type, $field_code){ 
        $arr = [];

        if($this->db->connect()){
            
            $sql = "call fields_get('$base_dn', '$type', '$field_code');";   
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

    function add($base_dn, $type, $field_code, $field_name, $active){  
        $arr = [];

        if($this->db->connect()){            
            $sql = "call fields_add('$base_dn', '$type', '$field_code', '$field_name', $active);"; 
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
                $sql = "call fields_edit('%s','%s', %s);";
                $sql = sprintf($sql, 
                    $item['FIELD_ID'],
                    $item['FIELD_NAME'],
                    $item['ACTIVE']
                );
                
                mysqli_query($this->db->conn, $sql);  

                $this->db->conn->close();
            }
        }
    }

    function delete($field_id){
        if($this->db->connect()){
            if($field_id){ 
                $sql = "call fields_delete('%s');";
                $sql = sprintf($sql, 
                    $field_id
                );
                
                mysqli_query($this->db->conn, $sql);  

                $this->db->conn->close();
            }
        }
    }
}
?>