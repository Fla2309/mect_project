<?php

include_once('connection.php');

class Groups extends DB
{

    public function retrieveGroups()
    {
        $query = $this->connect()->query('SELECT * FROM grupos WHERE id_grupo <> 0');
        $html = "";
        $count = 1;

        while ($row = mysqli_fetch_array($query)) {
            if ($count == 1) {
                $html = $html . "<div class=\"row\" style=\"align-content: center;\">";
            }

            $html = $html . "<div id=\"gr_" . $row['id_grupo'] . "\" class=\"col-sm px-5 py-5 mx-3 my-3\" style=\"background-color: white;\">";
            $html = $html . "<div class=\"p-1\">";
            $html = $html . "<h1>MECT " . $row['id_grupo'] . " " . $row['nombre_grupo'] . "</h1>";
            $html = $html . "<h4>" . $row['sede'] . "</h4>";
            $html = $html . "<button id=\"but_gr_" . $row['id_grupo'] . "\" type=\"button\" onclick=\"showGroupHtml(this);\" class=\"btn btn-primary\" style=\"width: 120px; text-align: left;\">";
            $html = $html . "Entrar<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button>";
            $html = $html . "</div>";
            $html = $html . "</div>";

            if ($count == 3) {
                $html = $html . "</div>";
                $count = 0;
            }

            $count++;
        }
        if ($count != 0) {
            $html = $html . "</div>";
        }

        return $html;
    }

    public function getGroupHtmlDropdownTags(){
        $modules = $this->connect()->query("SELECT id_grupo, nombre_grupo FROM grupos") or die($this->connect()->error);
        $html = '<option href=\"#\">Elige un grupo...</option>';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"group_{$module['id_grupo']}\" href=\"#\">{$module['nombre_grupo']}</option>";
        }
        return $html;
    }
    public function getUserLevelHtmlDropdownTags(){
        $modules = $this->connect()->query("SELECT id_nivel, nombre_nivel FROM niveles_usuario") or die($this->connect()->error);
        $html = '<option href=\"#\">Elige un nivel de usuario...</option>';
        foreach ($modules as $module) {
            $html = $html . "<option id=\"level_{$module['id_nivel']}\" href=\"#\">{$module['nombre_nivel']}</option>";
        }
        return $html;
    }
}

?>