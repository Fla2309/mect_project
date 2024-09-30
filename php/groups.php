<?php

include_once('connection.php');

class Groups extends DB
{
    private $conn;

    public function __construct(){
        $this->conn = (new DB)->connect();
    }

    public function prepareGroupsJson()
    {
        $query = $this->getGroupsFromDatabase();
        $groups = [];
        $array = [];

        while ($row = mysqli_fetch_array($query)) {
            $group = array(
                'groupId' => $row['id'],
                'groupNumber' => $row['id_grupo'],
                'groupName' => $row['nombre_grupo'],
                'location' => $row['sede']
            );
            array_push($groups, $group);
        }
        $array = [
            'groups' => $groups,
            'options' => $this->getUserPermissions()
        ];
        return $array;
    }

    public function prepareSingleGroupJson()
    {
        $group = mysqli_fetch_assoc($this->conn->query("SELECT * FROM grupos WHERE id_grupo = {$_GET['groupNumber']} AND sede = '{$_GET['location']}'")) or die($this->conn->error);
        return [
            'groupId' => $group['id'],
            'groupNumber' => $group['id_grupo'],
            'groupName' => $group['nombre_grupo'],
            'startDate' => $group['fecha_inicio'],
            'endDate' => $group['fecha_terminacion'],
            'location' => $group['sede']
        ];
    }

    public function getGroupHtmlDropdownTags()
    {
        $modules = $this->conn->query("SELECT id, id_grupo, nombre_grupo, sede FROM grupos ORDER BY id DESC") or die($this->conn->error);
        $html = '<option href=\"#\">Elige un grupo...</option>';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"group_{$module['id']}\" href=\"#\">MECT {$module['id_grupo']} {$module['nombre_grupo']} - {$module['sede']}</option>";
        }
        return $html;
    }

    public function getUserLevelHtmlDropdownTags()
    {
        $modules = $this->conn->query("SELECT id_nivel, nombre_nivel FROM niveles_usuario") or die($this->conn->error);
        $html = '<option href=\"#\">Elige un nivel de usuario...</option>';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"level_{$module['id_nivel']}\" href=\"#\">{$module['nombre_nivel']}</option>";
        }
        return $html;
    }

    public function getGroupsFromDatabase()
    {
        $query = $this->conn->query('SELECT * FROM grupos WHERE id_grupo <> 0 ORDER BY id DESC') or die($this->conn->error);
        return $query;
    }

    public function getUserPermissions()
    {
        $query = $this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id={$_GET['userId']}") or die($this->conn->error);
        switch (mysqli_fetch_assoc($query)['nivel_usuario']) {
            //1=consulta, 2=alta, 3=cambio, 4=baja
            case 1:
                return [1];
            case 2:
                return [1, 3];
            case 3:
            case 4:
                return [1, 2, 3, 4];
            default:
                break;
        }
    }

    public function createGroup()
    {
        try {
            $querySelect = $this->conn->query("SELECT * FROM grupos WHERE nombre_grupo = 
                    '{$_POST['groupName']}' AND sede = '{$_POST['location']}'")
                or die($this->conn->error);
            if ($querySelect->num_rows > 0)
                throw new Exception('Nombre de grupo ya existe');
            $queryInsert = $this->conn->query("INSERT INTO grupos (id_grupo, nombre_grupo, fecha_inicio, fecha_terminacion, sede)
                    VALUES ('{$_POST['groupId']}','{$_POST['groupName']}','{$_POST['startDate']}',
                    '{$_POST['endDate']}','{$_POST['location']}')") or die($this->conn->error);
            http_response_code(201);
            return $_POST;
        } catch (Exception $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }

    public function updateGroup(){
        $groupId = $_GET['groupId'];
        $groupNumber = $_POST['groupNumber'];
        $groupName = $_POST['groupName'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $location = $_POST['location'];

        $query = $this->conn->query("UPDATE grupos SET id_grupo={$groupNumber}, nombre_grupo='{$groupName}', 
        fecha_inicio='{$startDate}', fecha_terminacion='{$endDate}', sede='{$location}' WHERE id={$groupId}") or die($this->conn->error);

        if ($query) {
            http_response_code(201);
            return [
                'groupId'=> $groupId,
                'groupNumber'=> $groupNumber,
                'groupName'=> $groupName,
                'startDate'=> $startDate,
                'endDate'=> $endDate,
                'location'=> $location
            ];
        } else {
            http_response_code(400);
            return 1;
        }
    }
}