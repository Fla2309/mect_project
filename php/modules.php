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
        $count = 0;
        $percentage = 0;
        $totalCount = 0;
        $trabajosCount = 0;
        $tareasCount = 0;


        while ($row = mysqli_fetch_array($query)) {
            $count++;
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

    public function getModuleActivitiesDetails($type, $id)
    {
        $row = null;
        $actType = '';
        switch ($type) {
            case 1:
                $row = $this->connect()->query("SELECT tareas_modulos.id_tarea, tareas_modulos.nombre_tarea, modulos.nombre_modulo, tareas_modulos.comentarios, tareas_modulos.plantilla 
                FROM tareas_modulos, modulos 
                WHERE tareas_modulos.id_modulo = modulos.id_modulo 
                AND id_tarea = {$id}")->fetch_row();
                $actType = 'homework';
                break;
            case 2:
                $row = $this->connect()->query("SELECT trabajos_modulos.id_trabajo, trabajos_modulos.nombre_trabajo, modulos.nombre_modulo, trabajos_modulos.comentarios, trabajos_modulos.plantilla 
                FROM trabajos_modulos, modulos 
                WHERE trabajos_modulos.id_modulo = modulos.id_modulo 
                AND id_trabajo = {$id}")->fetch_row();
                $actType = 'activity';
                break;
        }
        http_response_code(200);
        return [
            'actId' => $row[0],
            'actName' => $row[1],
            'moduleName' => $row[2],
            'comments' => $row[3],
            'templateName' => $row[4],
            'actType' => $actType
        ];
    }

    public function deleteActivityFromModule($type, $actId)
    {
        $table = $type == 1 ? 'tareas_modulos' : 'trabajos_modulos';
        $idCol = $type == 1 ? 'id_tarea' : 'id_trabajo';
        $query = $this->connect()->query("UPDATE {$table} SET status = 1 WHERE {$idCol} = {$actId}");
        if ($query)
            http_response_code(201);
        else
            http_response_code(400);

    }

    public function updateActivityFromModule($type, $actId, $values)
    {
        $table = $type == 1 ? 'tareas_modulos' : 'trabajos_modulos';
        $idCol = $type == 1 ? 'id_tarea' : 'id_trabajo';
        $nameCol = $type == 1 ? 'nombre_tarea' : 'nombre_trabajo';
        $query = $this->connect()->query("UPDATE {$table} SET 
        {$nameCol} = '{$values['actName']}', 
        id_modulo = {$values['moduleId']}, 
        comentarios = '{$values['comments']}', 
        plantilla = '{$values['templateName']}' 
        WHERE {$idCol} = {$actId}");
        if ($query)
            http_response_code(201);
        else
            http_response_code(400);
    }

    public function createActivityFromModule($type, $values){
        $table = $type == 1 ? 'tareas_modulos' : 'trabajos_modulos';
        $nameCol = $type == 1 ? 'nombre_tarea' : 'nombre_trabajo';
        $query = $this->connect()->query("INSERT INTO {$table} (`nombre_tarea`, `id_modulo`, `comentarios`, `plantilla`, `status`) 
            VALUES ('{$values['actName']}', {$values['moduleId']}, '{$values['comments']}', '{$values['templateName']}', 0)");
        if ($query)
            http_response_code(201);
        else
            http_response_code(400);
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
            $query = $this->conn->query('SELECT * FROM tareas_modulos WHERE status = 0 AND id_modulo = ' . $this->moduleId) or die($this->conn->error);
        } else {
            $query = $this->conn->query('SELECT tareas_modulos.nombre_tarea, tareas_usuarios.fecha_subida, 
            tareas_modulos.comentarios, tareas_usuarios.adjunto, tareas_usuarios.revisado FROM tareas_modulos 
            INNER JOIN tareas_usuarios ON tareas_modulos.id_tarea = tareas_usuarios.id_tarea 
            WHERE status = 0 AND id_modulo = ' . $this->moduleId . ' AND id_usuario IN 
            (SELECT id FROM usuarios WHERE id = \'' . $this->userId . '\')') or die($this->conn->error);
        }
        return $query;
    }

    public function getTrabajosPerUser()
    {
        if ($this->admin) {
            $query = $this->conn->query("SELECT * FROM trabajos_modulos WHERE status = 0 AND id_modulo = {$this->moduleId}") or die($this->conn->error);
        } else {
            $query = $this->conn->query("SELECT trabajos_modulos.nombre_trabajo, trabajos_usuarios.fecha_subido, 
            trabajos_usuarios.revisado, trabajos_usuarios.adjunto FROM trabajos_modulos 
            INNER JOIN trabajos_usuarios ON trabajos_modulos.id_trabajo = trabajos_usuarios.id_trabajo
            WHERE status = 0 AND id_modulo = {$this->moduleId} AND id_usuario IN 
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
        $html = '';

        foreach ($this->getTareasPerUser() as $row) {
            $html = $html . "<a class=\"list-group-item list-group-item-action\"><div id=\"mod_hw_{$row['id_tarea']}\" class=\"d-flex w-100 justify-content-start\">";
            $html = $html . "<h5 class=\"mb-1\">{$row['nombre_tarea']}</h5>";
            $html = $html . '<a href="#" onclick="showEditPanel(this)" title="Editar"><img class="dashboard_icon m-2" src="img/edit.png"></a>';
            $html = $html . '<a href="#" onclick="deleteActivity(this)" title="Eliminar"><img class="dashboard_icon m-2" src="img/delete.png"></a>';
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
        $html = '';

        foreach ($this->getTrabajosPerUser() as $row) {
            $html = $html . "<a class=\"list-group-item list-group-item-action\"><div id=\"mod_act_{$row['id_trabajo']}\" class=\"d-flex w-100 justify-content-between\">";
            $html = $html . "<h5 class=\"mb-1\">{$row['nombre_trabajo']}</h5>";
            $html = $html . '<a href="#" onclick="showEditPanel(this)" title="Editar"><img class="dashboard_icon m-2" src="img/edit.png"></a>';
            $html = $html . '<a href="#" onclick="deleteActivity(this)" title="Eliminar"><img class="dashboard_icon m-2" src="img/delete.png"></a>';
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

    public function getModuleHtmlDropdownTags(){
        $modules = $this->conn->query("SELECT id_modulo, nombre_modulo FROM modulos") or die($this->conn->error);
        $html = '';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"mod_{$module['id_modulo']}\" href=\"#\">{$module['nombre_modulo']}</option>";
        }
        return $html;
    }
}
?>