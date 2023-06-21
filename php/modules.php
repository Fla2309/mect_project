<?php

include_once('connection.php');

class Module extends DB
{

    public function retrieveModules($group)
    {
        $query = $group != 0 ?
            $this->connect()->query('SELECT * FROM modulos WHERE id_modulo IN (SELECT id_modulo FROM modulos_grupos WHERE id_grupo = ' . $group . ' AND disponible > 0)') :
            $this->connect()->query('SELECT * FROM modulos');
        $cardHtml = "";
        $count = 1;
        $percentage = 0;
        $totalCount = 0;
        $trabajosCount = 0;
        $tareasCount = 0;


        while ($row = mysqli_fetch_array($query)) {
            $totalCount = $this->getTotalTrabajosTareas($row['id_modulo'])[0];
            $trabajosCount = $this->getCountTrabajos($_SESSION['user'], $row['id_modulo'])[0];
            $tareasCount = $this->getCountTareas($_SESSION['user'], $row['id_modulo'])[0];
            $percentage = $totalCount > 0 ?
                (100 * ($trabajosCount + $tareasCount)) / $totalCount :
                100;
            if ($count == 1)
                $cardHtml = $cardHtml . "<div class=\"row\" style=\"align-content: center;\">";
            $cardHtml = $cardHtml . "<div id=\"mod_{$row['id_modulo']}\" class=\"col-sm px-5 py-5 mx-3 my-3\" style=\"background-color: white;\">";
            $cardHtml = $cardHtml . "<div class=\"p-1\">";
            $cardHtml = $cardHtml . "<h2>{$row['nombre_modulo']}</h1>";
            $cardHtml = $cardHtml . "<h4>{$row['descripcion']}</h4>";
            $cardHtml = $group != 0 ? $cardHtml . "<p>{$percentage}% completado</p>" : $cardHtml;
            $cardHtml = $cardHtml . "<button id=\"but_mod_{$row['id_modulo']}\" type=\"button\" onclick=\"showModuleHtml(this);\" class=\"btn btn-primary\" style=\"width: 120px; text-align: left;\">
                Entrar<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button>";
            $cardHtml = $cardHtml . "</div></div>";
            if ($count == 3) {
                $cardHtml = $cardHtml . "</div>";
                $count = 0;
            }
            $count++;
        }
        if ($count != 0) {
            $cardHtml = $cardHtml . "</div>";
        }

        return $cardHtml;
    }

    private function getTotalTrabajosTareas($moduleId)
    {
        return mysqli_fetch_array($this->connect()->query('SELECT COUNT(*) FROM tareas_modulos 
        INNER JOIN trabajos_modulos ON tareas_modulos.id_modulo = trabajos_modulos.id_modulo 
        WHERE tareas_modulos.id_modulo IN (SELECT id_modulo FROM modulos WHERE id_modulo = ' . $moduleId . ')'));
    }

    private function getCountTareas($username, $moduleId)
    {
        return mysqli_fetch_array($this->connect()->query('SELECT COUNT(id_tarea) FROM tareas_usuarios WHERE revisado = 3 
        AND id_tarea IN (SELECT id_tarea FROM tareas_modulos WHERE id_modulo = ' . $moduleId . ') 
        AND id_usuario IN (SELECT id FROM usuarios WHERE login_user = \'' . $username . '\')'));
    }

    private function getCountTrabajos($username, $moduleId)
    {
        return mysqli_fetch_array($this->connect()->query('SELECT COUNT(id_trabajo) FROM trabajos_usuarios WHERE revisado = 3 
        AND id_trabajo IN (SELECT id_trabajo FROM trabajos_modulos WHERE id_modulo = ' . $moduleId . ')
        AND id_usuario IN (SELECT id FROM usuarios WHERE login_user = \'' . $username . '\')'));
    }
}

class UserModule
{
    private $userId;
    private $moduleId;
    private $conn;
    private $admin;

    public function __construct()
    {
        $this->userId = $_GET['userId'];
        $this->moduleId = $_GET['module'];
        $this->conn = (new DB())->connect();
        $this->setAdminPermissions($_GET['userId']);
    }

    public function getTareasPerUser()
    {
        if ($this->admin) {
            $query = $this->conn->query('SELECT * FROM tareas_modulos WHERE id_modulo = ' . $this->moduleId) or die($this->conn->error);
        } else {
            $query = $this->conn->query('SELECT tareas_modulos.nombre_tarea, tareas_usuarios.fecha_subida, 
            tareas_modulos.comentarios, tareas_usuarios.adjunto, tareas_usuarios.revisado FROM tareas_modulos 
            INNER JOIN tareas_usuarios ON tareas_modulos.id_tarea = tareas_usuarios.id_tarea 
            WHERE id_modulo = ' . $this->moduleId . ' AND id_usuario IN 
            (SELECT id FROM usuarios WHERE id = \'' . $this->userId . '\')') or die($this->conn->error);
        }
        return $query;
    }

    public function getTrabajosPerUser()
    {
        if ($this->admin) {
            $query = $this->conn->query("SELECT * FROM trabajos_modulos WHERE id_modulo = {$this->moduleId}") or die($this->conn->error);
        } else {
            $query = $this->conn->query("SELECT trabajos_modulos.nombre_trabajo, trabajos_usuarios.fecha_subido, 
            trabajos_usuarios.revisado, trabajos_usuarios.adjunto FROM trabajos_modulos 
            INNER JOIN trabajos_usuarios ON trabajos_modulos.id_trabajo = trabajos_usuarios.id_trabajo
            WHERE id_modulo = {$this->moduleId} AND id_usuario IN 
            (SELECT id FROM usuarios WHERE id = '{$this->userId}')") or die($this->conn->error);
        }

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

    public function getAdminPermissions()
    {
        return $this->admin;
    }

    function setAdminPermissions($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->admin = $query[0] > 1 ? true : false;
    }

    public function prepareHtmlTareas()
    {
        return $this->getAdminPermissions() ? $this->prepareHtmlTareasAdmin() : $this->prepareHtmlTareasStudent();
    }

    function prepareHtmlTareasAdmin()
    {
        $html = '<div class="d-flex justify-content-start mb-3"><button type="button" class="btn btn-primary" onclick="addHomework()"><img src="../img/plus.png" width="20">
        Añadir</button></div>';

        foreach ($this->getTareasPerUser() as $row) {
            $html = $html . '<a class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-start">';
            $html = $html . "<h5 class=\"mb-1\">{$row['nombre_tarea']}</h5>";
            $html = $html . '<a><img class="dashboard_icon m-2" src="img/edit.png"></a>';
            $html = $html . '<a><img class="dashboard_icon m-2" src="img/delete.png"></a>';
            $html = $html . '</div>';
            $html = $html . '</a><hr class="divider">';
        }

        return $html;
    }

    function prepareHtmlTareasStudent()
    {
        $html = "";
        $status = "";
        $statusLayout = "";
        $uplEnabled = false;

        foreach ($this->getTareasPerUser() as $row) {
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
            $html = ($status !== $statusLayout) ? $html . "<a href=\"" . $this->getUserLocalPath() . "tareas/{$row['adjunto']}\" download=\"{$row['adjunto']}\"><img src=\"img/download.png\" class=\"dashboard_icon m-2\" title=\"Descargar tarea\"></a>" : $html;
            $html = $html . '</form></div><hr class="divider">';
            $html = $html . '</a>';
        }

        return $html;
    }

    public function prepareHtmlTrabajos()
    {
        return $this->getAdminPermissions() ? $this->prepareHtmlTrabajosAdmin() : $this->prepareHtmlTrabajosStudent();
    }

    function prepareHtmlTrabajosAdmin()
    {
        $html = '<div class="d-flex justify-content-start mb-3"><button type="button" class="btn btn-primary" onclick="addActivity()"><img src="../img/plus.png" width="20">
        Añadir</button></div>';

        foreach ($this->getTrabajosPerUser() as $row) {
            $html = $html . '<a class="list-group-item list-group-item-action"><div class="d-flex w-100 justify-content-between">';
            $html = $html . "<h5 class=\"mb-1\">{$row['nombre_trabajo']}</h5>";
            $html = $html . '<a><img class="dashboard_icon m-2" src="img/edit.png"></a>';
            $html = $html . '<a><img class="dashboard_icon m-2" src="img/delete.png"></a>';
            $html = $html . '</div>';
            $html = $html . '</a><hr class="divider">';
        }

        return $html;
    }

    function prepareHtmlTrabajosStudent()
    {
        $html = "";
        $status = "";
        $statusLayout = "";
        $uplEnabled = false;

        foreach ($this->getTrabajosPerUser() as $row) {
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
            $html = $uplEnabled ? $html . '<label for="file-input"><img class="dashboard_icon m-2" src="img/upload.png" title ="Subir trabajo"></label><input style="display: none;" id="file-input" name="foto" type="file">' : $html;
            $html = ($status !== $statusLayout) ? $html . "<a href=\"" . $this->getUserLocalPath() . "trabajos/{$row['adjunto']}\" download=\"{$row['adjunto']}\"><img src=\"img/download.png\" class=\"dashboard_icon m-2\" title=\"Descargar trabajo\"></a>" : $html;
            $html = $html . '</form></div></a><hr class="divider">';
        }
        return $html;
    }

    public function prepareHtmlFeedback()
    {
        $html = "";

        while ($row = mysqli_fetch_array($this->getFeedbackPerUser())) {
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

    function getUserLocalPath()
    {
        $path = $this->conn->query("SELECT directorio_local 
        FROM usuario_web WHERE id_usuario={$this->userId}") or die($this->conn->error);
        return mysqli_fetch_row($path)[0];
    }
}
?>