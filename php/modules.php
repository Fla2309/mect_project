<?php

include_once('connection.php');

class Module extends DB
{
    private $conn;
    private $userId;
    private $user;
    public $userLevel;
    public function __construct($userId = null)
    {
        if($userId == null)
            $this->userId = $_GET['userId'];
        else
            $this->userId = $userId;
        $this->conn = (new DB())->connect();
        $this->userLevel = $this->getUserLevel();
    }

    public function retrieveModules()
    {
        $query = $this->userLevel > 1 ? 
        $this->conn->query('SELECT * FROM modulos') : 
        $this->conn->query("SELECT * FROM modulos WHERE id_modulo IN 
                (SELECT id_modulo FROM modulos_grupos WHERE id_grupo IN 
                    (SELECT id_grupo FROM usuarios WHERE id={$this->userId}) 
                AND disponible > 0)");
        $modules = [];
        $progress = 0;
        $totalCount = 0;
        $trabajosCount = 0;
        $tareasCount = 0;


        while ($row = mysqli_fetch_array($query)) {
            $totalCount = $this->getTotalTrabajosTareas($row['id_modulo']);
            $trabajosCount = $this->getCountTrabajos($row['id_modulo']);
            $tareasCount = $this->getCountTareas($row['id_modulo']);
            $progress = $totalCount > 0 ? (100 * ($trabajosCount + $tareasCount)) / $totalCount : 100;
            $module = array(
                'moduleId' => $row['id_modulo'],
                'moduleName' => $row['nombre_modulo'],
                'description' => $row['descripcion'],
                'progress' => number_format ($progress, 1)
            );
            array_push($modules, $module);
        }
        
        return $modules;
    }

    private function getTotalTrabajosTareas($moduleId)
    {
        $countTareas = mysqli_fetch_assoc($this->conn->query('SELECT COUNT(*) as count FROM tareas_modulos WHERE tareas_modulos.id_modulo = ' . $moduleId))['count'];
        $countTrabajos = mysqli_fetch_assoc($this->conn->query('SELECT COUNT(*) as count FROM trabajos_modulos WHERE trabajos_modulos.id_modulo  = ' . $moduleId))['count'];
        return $countTareas + $countTrabajos;
    }

    private function getCountTareas($moduleId)
    {
        return mysqli_fetch_assoc($this->conn->query("SELECT COUNT(id_tarea) as count FROM tareas_usuarios WHERE revisado = 3 
        AND id_tarea IN (SELECT id_tarea FROM tareas_modulos WHERE id_modulo = {$moduleId}) 
        AND id_usuario IN (SELECT id FROM usuarios WHERE id = {$this->userId})"))['count'];
    }

    private function getCountTrabajos($moduleId)
    {
        return mysqli_fetch_assoc($this->conn->query("SELECT COUNT(id_trabajo) as count FROM trabajos_usuarios WHERE revisado = 3 
        AND id_trabajo IN (SELECT id_trabajo FROM trabajos_modulos WHERE id_modulo = {$moduleId}) 
        AND id_usuario IN (SELECT id FROM usuarios WHERE id = {$this->userId})"))['count'];
    }

    public function getModuleActivitiesDetails($type, $id)
    {
        $row = null;
        $actType = '';
        switch ($type) {
            case 1:
                $row = $this->conn->query("SELECT tareas_modulos.id_tarea, tareas_modulos.nombre_tarea, modulos.nombre_modulo, tareas_modulos.comentarios, tareas_modulos.plantilla 
                FROM tareas_modulos, modulos 
                WHERE tareas_modulos.id_modulo = modulos.id_modulo 
                AND id_tarea = {$id}")->fetch_row();
                $actType = 'homework';
                break;
            case 2:
                $row = $this->conn->query("SELECT trabajos_modulos.id_trabajo, trabajos_modulos.nombre_trabajo, modulos.nombre_modulo, trabajos_modulos.comentarios, trabajos_modulos.plantilla 
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
        $query = $this->conn->query("UPDATE {$table} SET status = 1 WHERE {$idCol} = {$actId}");
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
        $query = $this->conn->query("UPDATE {$table} SET 
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

    public function createActivityFromModule($type, $values)
    {
        $table = $type == 1 ? 'tareas_modulos' : 'trabajos_modulos';
        $nameCol = $type == 1 ? 'nombre_tarea' : 'nombre_trabajo';
        $query = $this->conn->query("INSERT INTO {$table} (`nombre_tarea`, `id_modulo`, `comentarios`, `plantilla`, `status`) 
            VALUES ('{$values['actName']}', {$values['moduleId']}, '{$values['comments']}', '{$values['templateName']}', 0)");
        if ($query)
            http_response_code(201);
        else
            http_response_code(400);
    }

    public function getUserLevel()
    {
        $query = $this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id={$this->userId}") or die($this->conn->error);
        return mysqli_fetch_assoc($query)['nivel_usuario'];
    }
}

class UserModule
{
    private $userId;
    private $moduleId;
    private $conn;
    private $userLevel;

    public function __construct()
    {
        $this->userId = $_GET['userId'];
        $this->moduleId = $_GET['module'];
        $this->conn = (new DB())->connect();
        $this->setAdminPermissions($_GET['userId']);
    }

    public function getTareasPerUser()
    {
        if ($this->userLevel > 1) {
            $query = $this->conn->query('SELECT * FROM tareas_modulos WHERE status = 0 AND id_modulo = ' . $this->moduleId) or die($this->conn->error);
        } else {
            $query = $this->conn->query("SELECT tareas_modulos.id_tarea, tareas_modulos.nombre_tarea, tareas_usuarios.fecha_subida, 
            tareas_modulos.comentarios, tareas_usuarios.adjunto, tareas_usuarios.revisado, tareas_modulos.plantilla FROM tareas_modulos 
            INNER JOIN tareas_usuarios ON tareas_modulos.id_tarea = tareas_usuarios.id_tarea 
            WHERE status = 0 AND id_modulo = {$this->moduleId} AND id_usuario IN 
            (SELECT id FROM usuarios WHERE id = {$this->userId})") or die($this->conn->error);
        }
        return $query;
    }

    public function getTrabajosPerUser()
    {
        if ($this->userLevel > 1) {
            $query = $this->conn->query("SELECT * FROM trabajos_modulos WHERE status = 0 AND id_modulo = {$this->moduleId}") or die($this->conn->error);
        } else {
            $query = $this->conn->query("SELECT trabajos_modulos.id_trabajo, trabajos_modulos.nombre_trabajo, trabajos_usuarios.fecha_subido, 
            trabajos_usuarios.revisado, trabajos_usuarios.adjunto, trabajos_modulos.plantilla FROM trabajos_modulos 
            INNER JOIN trabajos_usuarios ON trabajos_modulos.id_trabajo = trabajos_usuarios.id_trabajo
            WHERE status = 0 AND id_modulo = {$this->moduleId} AND id_usuario IN 
            (SELECT id FROM usuarios WHERE id = {$this->userId})") or die($this->conn->error);
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
        return $this->userLevel > 1;
    }

    function setAdminPermissions($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->userLevel = $query[0];
    }

    public function prepareTareasJson()
    {
        return $this->getAdminPermissions() ? $this->prepareTareasJsonAdmin() : $this->prepareTareasJsonStudent();
    }

    function prepareTareasJsonAdmin()
    {
        $tareasList=[];

        foreach ($this->getTareasPerUser() as $row) {
            //options -> 1=consultas, 2=altas, 3=cambios, 4=bajas
            $options = $this->userLevel > 2 ? 
                    [1] : 
                    [1, 2, 3, 4];
            $tareas = array(
                'homeworkId' => $row['id_tarea'],
                'homeworkName' => $row['nombre_tarea'],
                'options' => $options
            );

            array_push($tareasList, $tareas);
        }

        return $tareasList;
    }

    function prepareTareasJsonStudent()
    {
    $tareasList=[];
    foreach ($this->getTareasPerUser() as $row) {
        $options = [];
        //options -> 1=plantilla, 2=cargar archivo, 3=descargar archivo,
        switch($row['revisado']){
            case 0: $options = ['read', 'upload']; break;
            case 1: $options = ['read', 'download']; break;
            case 2: $options = ['read', 'upload', 'download']; break;
            case 3: $options = ['read', 'download']; break;
            default: break;
        }
        
        $tareas = array(
            'homeworkId' => $row['id_tarea'],
            'homeworkName' => $row['nombre_tarea'],
            'dateUploaded' => $row['fecha_subida'],
            'comments' => $row['comentarios'],
            'file' => $row['adjunto'],
            'status' => $row['revisado'],
            'options' => $options,
            'userLocalPath' => $this->getUserLocalPath(),
            'template' => $row['plantilla']
        );

        array_push($tareasList, $tareas);
    }
    return $tareasList;
    }

    public function prepareHtmlTrabajos()
    {
        return $this->prepareHtmlTrabajosAdmin();
    }

    public function prepareTrabajosJson()
    {
        return $this->getAdminPermissions() ? $this->prepareTrabajosJsonAdmin() : $this->prepareTrabajosJsonStudent();
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

    function prepareTrabajosJsonAdmin()
    {
        $trabajosList=[];

        foreach ($this->getTrabajosPerUser() as $row) {
            //options -> 1=consultas, 2=altas, 3=cambios, 4=bajas
            $options = $this->userLevel > 2 ? 
                    [1] : 
                    [1, 2, 3, 4];
            $trabajos = array(
                'workId' => $row['id_trabajo'],
                'workName' => $row['nombre_trabajo'],
                'options' => $options
            );

            array_push($trabajosList, $trabajos);
        }

        return $trabajosList;
    }

    function prepareTrabajosJsonStudent()
    {
        $trabajosList=[];
        foreach ($this->getTrabajosPerUser() as $row) {
            $options = [];
            //options -> 1=plantilla, 2=cargar archivo, 3=descargar archivo,
            switch($row['revisado']){
                case 0: $options = ['read', 'upload']; break;
                case 1: $options = ['read', 'download']; break;
                case 2: $options = ['read', 'upload', 'download']; break;
                case 3: $options = ['read', 'download']; break;
                default: break;
            }
            
            $trabajos = array(
                'workId' => $row['id_trabajo'],
                'workName' => $row['nombre_trabajo'],
                'dateUploaded' => $row['fecha_subido'],
                'file' => $row['adjunto'],
                'status' => $row['revisado'],
                'options' => $options,
                'userLocalPath' => $this->getUserLocalPath(),
                'template' => $row['plantilla']
            );

            array_push($trabajosList, $trabajos);
        }
        return $trabajosList;
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

    public function prepareFeedbackJson()
    {
        $feedbackList=[];

        while ($row = mysqli_fetch_array($this->getFeedbackPerUser())) {
            $feedback = array(
                'author' => $row['autor'],
                'date' => $row['fecha'],
                'feedback' => $row['feedback']
            );

            array_push($feedbackList, $feedback);
        }

        return $feedbackList;
    }

    function getUserLocalPath()
    {
        $path = $this->conn->query("SELECT directorio_local 
        FROM usuario_web WHERE id_usuario={$this->userId}") or die($this->conn->error);
        return mysqli_fetch_row($path)[0];
    }

    public function getModuleHtmlDropdownTags()
    {
        $modules = $this->conn->query("SELECT id_modulo, nombre_modulo FROM modulos") or die($this->conn->error);
        $html = '';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"mod_{$module['id_modulo']}\" href=\"#\">{$module['nombre_modulo']}</option>";
        }
        return $html;
    }
}