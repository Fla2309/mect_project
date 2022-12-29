<?php

include_once('connection.php');

class Users
{
    private $user;
    private $conn;
    public function __construct($user)
    {
        $this->user = $user;
        $this->conn = (new DB())->connect();
    }

    //duplicated code (group.php)
    public function prepareHtmlUsuarios($users)
    {
        $html = '';
        $html = $html . '<ul class="list-group" id="usersList">';
        if ($users !== 0) {
            while ($user = mysqli_fetch_array($users)) {
                $html = $html . '<li class="list-group-item" id="user_' . $user['id'] . '"><a>';
                $html = $html . $user['nombre'] . ' ' . $user['apellidos'] . '&nbsp;&nbsp;';
                $html = $html . '<em class="text-muted">MECT '.$user['id_grupo'].' '.$user['nombre_grupo'].'</em></a>';
                $html = $html . '<a><img src="img/del_user.png" title="Eliminar usuario" class="dashboard_icon ms-4 me-1"></a>';
                $html = $html . '<a><img src="img/settings.png" title="Configuración" class="dashboard_icon m-1"></a>';
                $html = $html . '<a><img src="img/payment.png" title="Pagos" class="dashboard_icon  m-1"></a>';
                $html = $html . '<a><img src="img/books.png" title="Perfil académico" class="dashboard_icon  m-1"></a>';
                $html = $html . '</li>';
            }
        } else {
            $html = $html . '<h3>No hay usuarios para mostrar</h3>';
        }

        $html = $html . '</ul>';

        return $html;
    }

    public function getUsuarios()
    {
        $query = $this->conn->query('SELECT usuarios.id, usuarios.nombre, usuarios.apellidos, 
            usuarios.id_grupo, grupos.nombre_grupo, usuarios.correo, usuarios.telefono 
            FROM usuarios, grupos WHERE usuarios.id_grupo = grupos.id_grupo') or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }
}

?>