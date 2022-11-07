<?php

include_once 'connection.php';
include_once 'session.php';

class User extends DB
{
    private $name;
    private $lastname;
    private $prefName;
    private $group;
    private $mail;
    private $regDate;
    private $idUser;
    private $userLevel;
    

    public function userExists($user, $pass)
    {
        $md5pass = md5($pass);
        $query = $this->connect()->query("SELECT * FROM usuarios WHERE login_user = '".$user."' AND login_pass = '".$md5pass."'");

        if ($query->num_rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function setUser($user)
    {
        $query = $this->connect()->query("SELECT * FROM usuarios WHERE login_user = '".$user."'");

        foreach ($query as $currentUser) {
            $this->name = $currentUser['nombre'];
            $this->lastname = $currentUser['apellidos'];
            $this->prefName = $currentUser['nombre_preferido'] != '' 
            ? $currentUser['nombre_preferido'] : $currentUser['nombre'] ;
            $this->group = $currentUser['id_grupo'];
            $this->mail = $currentUser['correo'];
            $this->regDate = $currentUser['fecha_ingreso'];
            $this->idUser = $currentUser['id'];
            $this->userLevel = $currentUser['nivel_usuario'];
        }
    }

    public function getFullName()
    {
        return $this->name . " " . $this->lastname;
    }

    public function getPreferredName()
    {
        return $this->prefName;
    }

    public function getUserGroup()
    {
        return $this->group;
    }

    public function getUserLevel(){
        return $this->userLevel;
    }
}


?>