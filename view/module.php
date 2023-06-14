<?php
include_once('../php/connection.php');
class UserModule
{
    private $userId;
    private $moduleId;
    private $conn;

    public function __construct()
    {
        $this->userId = $_GET['userId'];
        $this->moduleId = $_GET['module'];
        $this->conn = (new DB())->connect();
    }

    public function getTareasPerUser()
    {
        $query = $this->conn
            ->query('SELECT tareas_modulos.nombre_tarea, tareas_usuarios.fecha_subida, 
        tareas_modulos.comentarios, tareas_usuarios.revisado FROM tareas_modulos 
        INNER JOIN tareas_usuarios ON tareas_modulos.id_tarea = tareas_usuarios.id_tarea 
        WHERE id_modulo = ' . $this->moduleId . ' AND id_usuario IN 
        (SELECT id FROM usuarios WHERE id = \'' . $this->userId . '\')') or die($this->conn->error);
        return $query;
    }

    public function getTrabajosPerUser()
    {
        $query = $this->conn
            ->query('SELECT trabajos_modulos.nombre_trabajo, trabajos_usuarios.fecha_subido, 
        trabajos_usuarios.revisado FROM trabajos_modulos 
        INNER JOIN trabajos_usuarios ON trabajos_modulos.id_trabajo = trabajos_usuarios.id_trabajo
        WHERE id_modulo = ' . $this->moduleId . ' AND id_usuario IN 
        (SELECT id FROM usuarios WHERE id = \'' . $this->userId . '\')') or die($this->conn->error);
        return $query;
    }

    public function getFeedbackPerUser()
    {
        $query = $this->conn->query("SELECT feedback_usuarios.id, modulos.id_modulo, modulos.nombre_modulo, feedback_usuarios.feedback, feedback_usuarios.autor, feedback_usuarios.fecha 
        FROM feedback_usuarios, modulos 
        WHERE modulos.id_modulo = feedback_usuarios.id_modulo 
        AND feedback_usuarios.id_modulo={$this->moduleId} 
        AND feedback_usuarios.id_usuario={$this->userId}") or die($this->conn->error);
        return $query;
    }

    public function getUsername()
    {
        return $this->userId;
    }

    public function getModule()
    {
        return $this->moduleId;
    }

    public function prepareHtmlTareas($rows)
    {
        $html = "";
        $status = "";
        $statusLayout = "";
        $uplEnabled = false;

        while ($row = mysqli_fetch_array($rows)) {
            $html = $html . '<a class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-between">';
            $html = $html . '<h5 class="mb-1">' . $row['nombre_tarea'] . '</h5>';
            $html = $html . '<small>Fecha de subida: ' . $row['fecha_subida'] . '</small>';
            $html = $html . '</div>';
            $html = $row['comentarios'] != null ? $html . '<p class="mb-1">' . $row['comentarios'] . '</p>' : $html . '<p class="mb-1">No hay comentarios</p>';
            switch ($row['revisado']) {
                case 0:
                    $status = "Pendiente";
                    $statusLayout = $status;
                    $uplEnabled = true;
                    break;
                case 1:
                    $status = "En revisión";
                    $statusLayout = '<span style="color: goldenrod; font-weight: bold;">' . $status . '</span>';
                    $uplEnabled = false;
                    break;
                case 2:
                    $status = "Rechazado";
                    $statusLayout = '<span style="color: darkred; font-weight: bold;">' . $status . '</span>';
                    $uplEnabled = true;
                    break;
                case 3:
                    $status = "Revisado";
                    $statusLayout = '<span style="color: dodgerblue; font-weight: bold;">' . $status . '</span>';
                    $uplEnabled = false;
                    break;
            }
            $html = $html . '<div style="display: inline-block"><div class="d-flex justify-content-center">';
            $html = $html . '<small class="text-muted"> Estado: ' . $statusLayout . '</small></div>';
            $html = $html . '<form><a href="resources/templates/prueba-1.docx" download="plantilla tarea 1.docx"><img src="img/template.png" class="dashboard_icon m-2" title="Descargar plantilla"></a>';
            $html = $html . '<input hidden="true" name="MAX_FILE_SIZE" value="10485760">';
            $html = $uplEnabled ? $html . '<label for="file-input"><img class="dashboard_icon m-2" src="img/upload.png" title ="Subir tarea"></label><input style="display: none;" id="file-input" name="foto" type="file">' : $html;
            $html = ($status !== $statusLayout) ? $html . '<a href="resources/users/" download="plantilla tarea 1.docx"><img src="img/download.png" class="dashboard_icon m-2" title="Descargar tarea"></a>' : $html;
            $html = $html . '</form></div><hr class="divider">';
            $html = $html . '</a>';
        }

        return $html;
    }

    public function prepareHtmlTrabajos($rows)
    {
        $html = "";
        $status = "";
        $statusLayout = "";
        $uplEnabled = false;

        while ($row = mysqli_fetch_array($rows)) {
            $html = $html . '<a class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-between">';
            $html = $html . '<h5 class="mb-1">' . $row['nombre_trabajo'] . '</h5>';
            $html = $html . '<small>Fecha de subida: ' . $row['fecha_subido'] . '</small>';
            $html = $html . '</div>';
            switch ($row['revisado']) {
                case 0:
                    $status = "Pendiente";
                    $statusLayout = $status;
                    $uplEnabled = true;
                    break;
                case 1:
                    $status = "En revisión";
                    $statusLayout = '<span style="color: goldenrod; font-weight: bold;">' . $status . '</span>';
                    $uplEnabled = false;
                    break;
                case 2:
                    $status = "Rechazado";
                    $statusLayout = '<span style="color: darkred; font-weight: bold;">' . $status . '</span>';
                    $uplEnabled = true;
                    break;
                case 3:
                    $status = "Revisado";
                    $statusLayout = '<span style="color: dodgerblue; font-weight: bold;">' . $status . '</span>';
                    $uplEnabled = false;
                    break;
            }
            $html = $html . '<div style="display: inline-block"><div class="d-flex justify-content-center">';
            $html = $html . '<small class="text-muted"> Estado: ' . $statusLayout . '</small></div>';
            $html = $html . '<form><a href="resources/templates/prueba-1.docx" download="plantilla tarea 1.docx"><img src="img/template.png" class="dashboard_icon m-2" title="Descargar plantilla"></a>';
            $html = $html . '<input hidden="true" name="MAX_FILE_SIZE" value="10485760">';
            $html = $uplEnabled ? $html . '<label for="file-input"><img class="dashboard_icon m-2" src="img/upload.png" title ="Subir tarea"></label><input style="display: none;" id="file-input" name="foto" type="file">' : $html;
            $html = ($status !== $statusLayout) ? $html . '<a href="resources/users/" download="plantilla tarea 1.docx"><img src="img/download.png" class="dashboard_icon m-2" title="Descargar tarea"></a>' : $html;
            $html = $html . '</form></div><hr class="divider">';
            $html = $html . '</a>';
        }

        return $html;
    }

    public function prepareHtmlFeedback($rows)
    {
        $html = "";

        while ($row = mysqli_fetch_array($rows)) {
            $html = $html . '<a class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-between">';
            $html = $html . '<h5 class="mb-1">Publicado por: ' . $row['autor'] . '</h5>';
            $html = $html . '<small>Fecha de subido: ' . $row['fecha'] . '</small>';
            $html = $html . '</div>';
            $html = $html . '<div style="display: inline-block"><div class="text-start">';
            $html = $html . "{$row['feedback']}</div>";
            $html = $html . '</div><hr class="divider">';
            $html = $html . '</a>';
        }

        return $html;
    }
}
?>

<html>

<head>
</head>

<body>
    <?php
    $userModule = new UserModule();
    ?>
    <button type="button" class="btn btn-primary" onclick="reloadModules()"><img src="../img/left-arrow.png" width="20">
        Volver</button>
    <div class="px-2 py-2 mx-2 my-2">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-pills card-header-tabs mb-1">
                    <li class="nav-item">
                        <a class="nav-link active" href="#trabajos" data-bs-toggle="tab">Trabajos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tareas" data-bs-toggle="tab">Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feedback" data-bs-toggle="tab">Feedback</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane card-body active" id="trabajos">
                    <?php
                    $htmlTrabajos = $userModule->prepareHtmlTrabajos($userModule->getTrabajosPerUser());
                    echo $htmlTrabajos !== "" ? $htmlTrabajos : "<h5>No hay trabajos para mostrar</h5>"
                    ?>
                </div>
                <div class="tab-pane card-body" id="tareas">
                    <?php
                    $htmltareas = $userModule->prepareHtmlTareas($userModule->getTareasPerUser());
                    echo $htmltareas !== "" ? $htmltareas : "<h5>No hay tareas para mostrar</h5>"
                    ?>
                </div>
                <div class="tab-pane card-body" id="feedback">
                    <?php
                    $htmlFeedback = $userModule->prepareHtmlFeedback($userModule->getFeedbackPerUser());
                    echo $htmlFeedback !== "" ? $htmlFeedback : "<h5>No hay feedback para mostrar</h5>"
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>