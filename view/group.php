<?php
use FTP\Connection;

include_once('../php/connection.php');

class UserGroup
{
    private $user;
    private $groupId;
    private $conn;
    public function __construct($user, $groupId)
    {
        $this->user = $user;
        $this->groupId = $groupId;
        $this->conn = (new DB())->connect();
    }

    public function prepareHtmlUsuarios($users)
    {
        $html = '';
        $html = $html . '<ul class="list-group" id="usersList">';

        if ($users !== 0) {
            while ($user = mysqli_fetch_array($users)) {
                $html = $html . '<li class="list-group-item" id="' . $user['id'] . '"><a>';
                $html = $html . $user['nombre'] . ' ' . $user['apellidos'] . '</a>';
                $html = $html . '<a><img src="img/del_user.png" title="Eliminar usuario" class="dashboard_icon m-2"></a>';
                $html = $html . '<a><img src="img/settings.png" title="Configuración" class="dashboard_icon m-2"></a>';
                $html = $html . '<a><img src="img/payment.png" title="Pagos" class="dashboard_icon m-2"></a>';
                $html = $html . '<a><img src="img/books.png" title="Perfil académico" class="dashboard_icon m-2"></a>';
                $html = $html . '</li>';
            }
        } else {
            $html = $html . '<h3>No hay usuarios para mostrar</h3>';
        }

        $html = $html . '</ul>';

        return $html;
    }

    public function prepareHtmlModulos($modules)
    {

    }

    public function getUsuarios()
    {
        $query = $this->conn->query('SELECT * FROM usuarios 
        WHERE id_grupo = ' . $this->groupId) or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function getModulos()
    {
        $query = $this->conn->query('SELECT * FROM modulos_grupos 
        WHERE id_grupo = ' . $this->groupId) or die($this->conn->error);
        return $query;
    }
}

?>

<html lang="en">

<head>
</head>

<body>
    <?php $userGroup = new UserGroup($_GET['user'], $_GET['group']) ?>
    <button type="button" class="btn btn-primary" onclick="reloadGroups()"><img src="../img/left-arrow.png" width="20">
        Volver</button>
    <div class="px-2 py-2 mx-2 my-2">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#usuarios" data-bs-toggle="tab">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modulos" data-bs-toggle="tab">Módulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pagos" data-bs-toggle="tab">Pagos</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane card-body active" id="usuarios">
                    <div class="col-4 mb-3 d-flex">
                        <div class="col-7">
                            <input class="form-control" type="text" id="txtUser" onkeyup="searchUser()"
                            placeholder="Buscar..." title="Escribe el nombre">
                        </div>
                        <div class="col-5">
                            <button type="button" class="btn btn-primary">Agregar Usuario</button>
                        </div>
                    </div>
                    <?php
                    echo $userGroup->prepareHtmlUsuarios($userGroup->getUsuarios())
                        ?>
                </div>
                <div class="tab-pane card-body" id="modulos">
                    <?php
                    echo $userGroup->prepareHtmlModulos($userGroup->getModulos());
                    ?>
                </div>
                <div class="tab-pane card-body" id="informacion">
                    <h5 class="card-title">Info</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>