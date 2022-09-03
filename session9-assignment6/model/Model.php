<?php

class Model{
    protected $table = '';
    protected $id = '';

    protected $connection = '';

    public function __construct(){
        $this->connection = new mysqli('localhost','root','','session9_assignment6');
    }

    public function select($select ='*', $where=[],$join='',$order_by='',$single=false){
        $query = "SELECT {$select} FROM `{$this->table}`";
        if(!empty($join)){
            $query .= $join;
        }
        
        if(count($where)){
            $query .= " WHERE ";
            
            foreach($where as $column => $value){
                $query .= "{$column}='$value' AND ";
            }
           $query = trim($query," AND ");
            
        }

        
        if(!empty($order_by)){
            $query .= $order_by;
        }
        
    

        $result = $this->connection->query($query);
        $data = null;
        if($single){
            $data = $result->fetch_assoc();
        }else{
            $data = $result->fetch_all(MYSQLI_ASSOC);
        }
        
        return $data;
    }

    public function insert($data){

        $columns = '';
        $values = '';
        foreach($data as $column=>$value){
            $columns .= "{$column}, ";
            $values .= "'{$value}', ";
        }
        $columns = trim($columns,', ');
        $values = trim($values,', ');

        $query = "INSERT INTO {$this->table} ({$columns}) VALUES({$values})";
        
        $this->connection->query($query);         
        return $this->connection->insert_id;
    }

    public function update($data,$id){
        $update_str = '';        
        foreach($data as $column=>$value){
            $update_str .= "`{$column}` = '{$value}', ";            
        }
        $update_str = trim($update_str,', ');
        
        $query = "UPDATE `{$this->table}` SET {$update_str} WHERE id = '{$id}'";       
        return $this->connection->query($query);
    }

    public function delete($id){
        $query = "DELETE FROM `{$this->table}` WHERE id = '{$id}'";
        return $this->connection->query($query);
    }
}