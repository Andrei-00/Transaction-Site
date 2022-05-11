<?php

class DBHandler{
    
    private static $inst = null;
    private $conn;
    private $activeTransaction = 0;

    private function __construct()
    {   
        self::connect_db();
    }

    public static function getInstance(){
        if(!self::$inst){
            self::$inst= new DBHandler();
        }
        return self::$inst;
    }

    public function getConnection(){
        return $this->conn;
    }

    public function getActiveTransaction(){
        return $this->activeTransaction;
    }

    public function setActiveTransaction($x){
        $this->activeTransaction = $x;
    }

    private function connect_db(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "passwords";
    
        try{
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            //set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
        } catch(PDOException $e){
            if (isset ($conn)) 
            $this->conn = null;
            exit ("Connection failed: " . $e->getMessage());
        }
    }
}
?>