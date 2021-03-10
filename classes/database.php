<?php
class Database{
    protected $location;
    protected $username;
    protected $password;
    protected $database;
    protected $connection;

    
    public function __construct(){
        $this->location="localhost";
        $this->username="root";
        $this->password="";
        $this->database="final_project_oopphp";
    }


    public function __destruct(){
        mysqli_close($this->connection);
    }


    public function connect(){
        $this->connection=@mysqli_connect(
            $this->location,
            $this->username, 
            $this->password, 
            $this->database
        );

        if(!$this->connection){
            return false;
        }else{
            // special characters to server
            $this->query("SET NAMES utf8");
            return $this->connection;
        } 
            
    }


    public function query($query){
        return mysqli_query($this->connection, $query);
    }


    public function fetch_assoc($result){
        return mysqli_fetch_assoc($result);
    }


    public function fetch_object($result){
        return mysqli_fetch_object($result);
    }


    public function error(){
        return mysqli_error($this->connection);
    }


    public function errno(){
        return mysqli_errno($this->connection);
    }


    public function num_rows($result){
        return mysqli_num_rows($result);
    }

    // returns an id of the last DB entry
    public function insert_id(){
        return mysqli_insert_id($this->connection);
    }

}
?>