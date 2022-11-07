<?php
include_once('../php/connection.php');
class UserModule
{
    private $username;
    private $moduleId;

    public function __construct()
    {
        $this->username = $_GET['user'];
        $this->moduleId = $_GET['module'];
    }

    public function getTareasPerUser()
    {
        $conn=(new DB())->connect();
        $query = $conn
        ->query('SELECT tareas_modulos.nombre_tarea, tareas_usuarios.fecha_subida, 
        tareas_modulos.comentarios, tareas_usuarios.revisado FROM tareas_modulos 
        INNER JOIN tareas_usuarios ON tareas_modulos.id_tarea = tareas_usuarios.id_tarea 
        WHERE id_modulo = '.$this->moduleId.' AND id_usuario IN 
        (SELECT id FROM usuarios WHERE login_user = \''.$this->username.'\')')or die ($conn->error);;
        return $query;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getModule(){
        return $this->moduleId;
    }

    public function prepareHtmlTareas($rows)
    {
        $html = "";

        while ($row = mysqli_fetch_array($rows)) {
            $html = $html.'<a class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-between">';
            $html = $html.'<h5 class="mb-1">' . $row['nombre_tarea'] . '</h5>';
            $html = $html.'<small>Fecha de subida: ' . $row['fecha_subida'] . '</small>';
            $html = $html.'</div>';
            $html = $row['comentarios'] != null ? $html.'<p class="mb-1">' . $row['comentarios'] . '</p>' : $html.'<p class="mb-1">No hay comentarios</p>';
            $html = $html.'<small class="text-muted"> Estado: ' . ($row['revisado'] > 0 ? 'Revisado' : 'Pendiente') . '</small>';
            $html = $html.'</a>';
        }

        return $html;
    }
}
?>

<html>
<head>
</head>
<body>
    <div class="px-2 py-2 mx-2 my-2">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#trabajos" data-bs-toggle="tab">Trabajos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tareas" data-bs-toggle="tab">Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informacion" data-bs-toggle="tab">Información</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane card-body active" id="trabajos">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">tareas_modulos.Nombre Tarea</h5>
                            <small>tareas_usuarios.Fecha subida</small>
                        </div>
                        <p class="mb-1">tareas_usuarios.Comentarios</p>
                        <small class="text-muted">(tareas_usuarios.revisado)Status:</small>
                    </a>
                </div>
                <div class="tab-pane card-body" id="tareas">
                    <?php
                    $userModule=new UserModule();
                    echo $userModule->prepareHtmlTareas($userModule->getTareasPerUser());
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