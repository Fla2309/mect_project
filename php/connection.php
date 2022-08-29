<?php

class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'localhost';
        $this->db       = 'mect_dev';
        $this->user     = 'root';
        $this->password = "";
        $this->charset  = 'utf8';
    }

    /*function connect(){
    
        try{
            
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
    
            return $pdo;

        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }   
    }*/

    function connect(){
        $mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
        if($mysqli->connect_errno){
            die("Error de conexión: ".$mysqli->connect_error);
        }
        return $mysqli;
    }
}

?>