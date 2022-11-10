<?php

include_once('connection.php');

class Settings
{
    private $username;
    public function __construct($username)
    {
        $this->username = $username;
    }

    public function retrieveSettings()
    {
        $query = (new DB)->connect()->query('SELECT id,nombre,apellidos,id_pl,usuarios.id_grupo,nombre_grupo,fecha_ingreso,nombre_preferido,nivel_usuario,login_user,login_pass,correo,telefono 
        FROM usuarios, grupos 
        WHERE login_user=\'' . $this->username . '\' AND usuarios.id_grupo = grupos.id_grupo;');
        return mysqli_fetch_assoc($query);
    }
}

?>