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

    public function prepareHtmlModulos($modules)
    {
        $html = '';
        $html = $html . '<ul class="list-group" id="modulesList">';

        if ($modules !== 0) {
            while ($module = mysqli_fetch_array($modules)) {
                $html = $html . '<li class="list-group-item" id="' . $module['id_modulo'] . '"><a>';
                $html = $html . $module['nombre_modulo'] . '</a>';
                $html = $html . '<a><img src="img/eye.png" title="Ver detalles" class="dashboard_icon ms-4 me-1"></a>';
                $html = $html . '<a><img src="img/payment.png" title="Pagos grupales" class="dashboard_icon  m-1"></a>';
                $html = $html . '<p><em>' . ($module['descripcion'] !== null ? $module['descripcion'] : 'No hay descripción disponible') . '</em></p>';
                $html = $html . '<div class="form-check">';
                $html = $module['disponible'] > 0 ? 
                    $html . '<input class="form-check-input" type="checkbox" value="" id="' . $module['id_modulo'] . '_enabled" checked><label class="form-check-label" for="flexCheckChecked">Disponible</label></div>' :
                    $html . '<input class="form-check-input" type="checkbox" value="" id="' . $module['id_modulo'] . '_enabled"><label class="form-check-label" for="flexCheckDefault">Disponible</label></div>';
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
        $query = $this->conn->query('SELECT * FROM usuarios 
        WHERE id_grupo = ' . $this->groupId) or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function getModulos()
    {
        $query = $this->conn->query('SELECT modulos_grupos.id, modulos_grupos.id_modulo, modulos.nombre_modulo, 
        modulos.descripcion, modulos_grupos.id_grupo, modulos_grupos.fecha_impartido, modulos_grupos.disponible 
        FROM modulos_grupos, modulos 
        WHERE modulos_grupos.id_modulo = modulos.id_modulo AND modulos_grupos.id_grupo = ' . $this->groupId) or die($this->conn->error);
        return $query;
    }

    public function getGroupName()
    {
        $row = mysqli_fetch_assoc($this->conn->query('SELECT * FROM grupos WHERE id_grupo = ' . $this->groupId));
        return 'MECT ' . $row['id_grupo'] . ' ' . $row['nombre_grupo'];
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
        <div class="card">
            <div class="card-header">
                <h2>
                    <?php echo $userGroup->getGroupName(); ?>
                </h2>
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
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtUser" onkeyup="searchUser()"
                                placeholder="Buscar..." title="Escribe el nombre">
                        </div>
                        <div class="col-5 ms-4">
                            <button type="button" class="btn btn-primary">Agregar Usuario</button>
                        </div>
                    </div>
                    <div id="usersDiv">
                        <?php
                        echo $userGroup->prepareHtmlUsuarios($userGroup->getUsuarios())
                            ?>
                    </div>
                    <div id="usersRighPanel" class="col-9" hidden="true">

                    </div>
                </div>
                <div class="tab-pane card-body" id="modulos">
                    <div class="col-4 mb-3">
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtModule" onkeyup="searchModule()"
                                placeholder="Buscar..." title="Escribe el nombre">
                        </div>
                    </div>
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