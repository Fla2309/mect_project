<?php

include_once('connection.php');

class Groups extends DB
{

    public function prepareGroupsJson()
    {
        $query = $this->getGroupsFromDatabase();
        $groups = [];
        $array = [];

        while ($row = mysqli_fetch_array($query)) {
            $group = array(
                'groupId' => $row['id_grupo'],
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

    public function getGroupHtmlDropdownTags()
    {
        $modules = $this->connect()->query("SELECT id_grupo, nombre_grupo FROM grupos") or die($this->connect()->error);
        $html = '<option href=\"#\">Elige un grupo...</option>';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"group_{$module['id_grupo']}\" href=\"#\">{$module['nombre_grupo']}</option>";
        }
        return $html;
    }

    public function getUserLevelHtmlDropdownTags()
    {
        $modules = $this->connect()->query("SELECT id_nivel, nombre_nivel FROM niveles_usuario") or die($this->connect()->error);
        $html = '<option href=\"#\">Elige un nivel de usuario...</option>';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"level_{$module['id_nivel']}\" href=\"#\">{$module['nombre_nivel']}</option>";
        }
        return $html;
    }

    public function getGroupsFromDatabase()
    {
        $query = $this->connect()->query('SELECT * FROM grupos WHERE id_grupo <> 0') or die($this->connect()->error);
        return $query;
    }

    public function getUserPermissions()
    {
        $query = $this->connect()->query("SELECT nivel_usuario FROM usuarios WHERE id={$_GET['userId']}") or die($this->connect()->error);
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
}