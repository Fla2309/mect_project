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
    private $admin;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
        $this->setAdminPermissions($userId);
    }

    function setAdminPermissions($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->admin = $query[0] > 1 ? true : false;
    }

    public function retrieveSettings($targetUser = null)
    {
        if ($this->userId !== $_SESSION['userId'] && !$this->admin)
            return 406;
        if ($targetUser != null) {
            $data = [];
            $query = mysqli_fetch_assoc($this->conn->query("SELECT id,nombre,apellidos,id_pl,usuarios.id_grupo,nombre_grupo,fecha_ingreso,nombre_preferido,nivel_usuario,login_user,login_pass,correo,telefono 
                FROM usuarios, grupos 
                WHERE id={$targetUser} AND usuarios.id_grupo = grupos.id_grupo;"));
            $data = [
                'targetUserId' => $query['id'],
                'targetUserName' => $query['nombre'],
                'targetUserLastname' => $query['apellidos'],
                'targetUserPlId' => $query['id_pl'],
                'targetUserGroupId' => $query['id_grupo'],
                'targetUserGroupName' => $query['nombre_grupo'],
                'targetUserDate' => $query['fecha_ingreso'],
                'targetUserPrefName' => $query['nombre_preferido'],
                'targetUserLevel' => $query['nivel_usuario'],
                'targetUserLogin' => $query['login_user'],
                'targetUserMail' => $query['correo'],
                'targetUserPhone' => $query['telefono']
            ];
            return $data;
        } else {
            $query = $this->conn->query("SELECT id,nombre,apellidos,id_pl,usuarios.id_grupo,nombre_grupo,fecha_ingreso,nombre_preferido,nivel_usuario,login_user,login_pass,correo,telefono 
                FROM usuarios, grupos 
                WHERE id={$this->userId} AND usuarios.id_grupo = grupos.id_grupo;");
            return mysqli_fetch_assoc($query);
        }
    }

    public function saveSettings()
    {
        $string = '';
        $query = $this->retrieveUser();
        $user = $query->fetch_object();
        if (isset($_GET[$this->settings[9][0]]) && $_GET['type'] != 5) {
            if ($this->validateLogin($_GET[$this->settings[9][0]])) {
                http_response_code(406);
                echo 'El usuario ingresado ya existe';
                return;
            }
        }
        for ($param = 2; $param <= count($this->settings); $param++) {
            if (isset($_GET[$this->settings[$param][0]])) {
                if ($user->nivel_usuario >= $this->settings[$param][2] || $_GET['type'] == 5) {
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
        try {
            $query = $this->conn->query('UPDATE usuarios SET ' . $string . ' WHERE id = ' . $this->userId) or die($this->conn->error);
            http_response_code(201);
            return $this->retrieveUser()->fetch_object();
        } catch (Exception) {
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
        if ($this->isPasswordValid($userId, $oldPassword)) {
            $this->conn->query('UPDATE usuarios SET login_pass = \'' . md5($newPassword) . '\' WHERE id = \'' . $this->userId . '\'') or die($this->conn->error);
            http_response_code(200);
        } else {
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
        $row = $this->conn->query("SELECT * FROM modulo_personal WHERE id_usuario=" . $userId)->fetch_row();
        $data = [
            'userId' => $row[1],
            'cvName' => $row[2],
            'registrationName' => $row[3],
            'idFrontName' => $row[4],
            'idBackName' => $row[5],
        ];
        http_response_code(201);
        return $data;
    }

    public function setProfilePicture($userId, $pictureName, $pictureBody)
    {
        if (unlink('../' . $_SESSION['foto_perfil'])) {
            $pictureFileName = $pictureName;
            $pictureName = str_replace(
                explode('/', $_SESSION['foto_perfil'])[count(explode('/', $_SESSION['foto_perfil'])) - 1],
                $pictureName,
                $_SESSION['foto_perfil']
            );
            $file_pointer = fopen('../' . $pictureName, 'w+');
            fwrite($file_pointer, $pictureBody);
            fclose($file_pointer);
            $this->conn->query("UPDATE usuario_web SET foto_perfil = '{$pictureName}' WHERE id_usuario = '{$userId}'") or die($this->conn->error);
            $_SESSION['foto_perfil'] = $pictureName;
            http_response_code(201);
        } else {
            http_response_code(400);
        }
        return [
            'profilePicName' => $pictureFileName,
            'profilePicPath' => '../' . $pictureName,
        ];
    }
}

?>