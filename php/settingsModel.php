<?php
include_once('connection.php');
session_start();

class Settings
{
    private $conn;
    private $settings = [
        1 => array('userId', 'id', 3),
        2 => array('userName', 'nombre', 2),
        3 => array('UserLastname', 'apellidos', 2),
        4 => array('userPL', 'id_pl', 2),
        5 => array('userGroup', 'id_grupo', 2),
        6 => array('userDate', 'fecha_ingreso', 2),
        7 => array('userAlias', 'nombre_preferido', 1),
        8 => array('userLevel', 'nivel_usuario', 2),
        9 => array('userLogin', 'login_user', 1),
        10 => array('userPass', 'login_pass', 1),
        11 => array('userMail', 'correo', 1),
        12 => array('userPhone', 'telefono', 1)
    ];
    private $userId;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
    }

    function retrieveSettings()
    {
        if ($this->userId !== $_SESSION['userId'])
            return 406;
        $query = (new DB)->connect()->query('SELECT id,nombre,apellidos,id_pl,usuarios.id_grupo,nombre_grupo,fecha_ingreso,nombre_preferido,nivel_usuario,login_user,login_pass,correo,telefono 
        FROM usuarios, grupos 
        WHERE id=\'' . $this->userId . '\' AND usuarios.id_grupo = grupos.id_grupo;');
        return mysqli_fetch_assoc($query);
    }

    public function saveSettings()
    {
        $string = '';
        $query = $this->retrieveUser();
        $user = $query->fetch_object();
        if (isset($_GET[$this->settings[9][0]])) {
            if ($this->validateLogin($_GET[$this->settings[9][0]])) {
                echo 'El usuario ingresado ya existe';
                return;
            }
        }
        for ($param = 2; $param <= count($this->settings); $param++) {
            if (isset($_GET[$this->settings[$param][0]])) {
                if ($user->nivel_usuario >= $this->settings[$param][2]) {
                    $string = $string . $this->settings[$param][1] . ' = \'' . $_GET[$this->settings[$param][0]] . '\'';
                    $param++;
                    if ($param >= count($_GET))
                        break;
                    $string = $string . ', ';
                } else {
                    echo 'Usuario no autorizado para registrar los cambios hechos';
                    http_response_code(403);
                    return;
                }
            }
        }
        try{
            $query = $this->conn->query('UPDATE usuarios SET ' . $string . ' WHERE id = ' . $this->userId) or die($this->conn->error);
            http_response_code(201);
            return $this->retrieveUser()->fetch_object();
        }catch(Exception){
            echo $string;
            http_response_code(400);
        }
    }

    function validateLogin($username)
    {
        return $this->conn->query('SELECT id FROM `usuarios` WHERE login_user = \'' . $username . '\'')->fetch_row() !== null;
    }

    function retrieveUser()
    {
        return $this->conn->query("SELECT * FROM usuarios WHERE id = " . $this->userId);
    }

    public function savePassword($userId, $oldPassword, $newPassword)
    {
        if ($this->isPasswordValid($userId, $oldPassword)){
            $this->conn->query('UPDATE usuarios SET login_pass = \'' . md5($newPassword) . '\' WHERE id = \'' . $this->userId . '\'') or die($this->conn->error);
            http_response_code(200);
        }
        else {
            http_response_code(403);
        }
        return;
    }

    function isPasswordValid($userId, $password)
    {
        return $this->conn->query("SELECT login_pass FROM usuarios WHERE id=" . $userId)->fetch_row()[0] === md5($password);
    }
    
    public function getPersonalModuleDocuments($userId)
    {
        $row = $this->conn->query("SELECT * FROM modulo_personal WHERE id_usuario=" . $userId)->fetch_row() ;
        $data = [
            'userId' => $row[1],
            'cvName' => $row[2],
            'registrationName' => $row[3],
            'idFrontName' => $row[4],
            'idBackName' => $row[5],
        ];
        return $data;
    }
}

?>