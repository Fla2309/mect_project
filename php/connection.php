<?php
#function connect()
#{
#    $server="localhost";
#    $user="root";
#    $pass="";
#    $db="mect_dev";
#    $conn = mysqli_connect($server, $user, $pass);
#    if (!$conn){
#        die("No hay conexión a la base de datos".mysqli_connect_error());
#    }
#    mysqli_select_db($conn, $db);
#    #mysql_query("SET NAME 'utf8'");
#    return $conn;
#}

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
        $this->charset  = 'utf8mb4';
    }

    function connect(){
    
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
    }
}

?>