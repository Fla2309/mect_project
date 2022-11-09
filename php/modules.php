<?php

include_once('connection.php');

class Module extends DB
{

    public function retrieveModules($group)
    {
        $query = $this->connect()->query('SELECT * FROM modulos WHERE id_modulo IN (SELECT id_modulo FROM modulos_grupos WHERE id_grupo = '.$group.' AND disponible > 0)');
        $cardHtml = "";
        $count = 1;
        $percentage=0;
        $totalCount=0;
        $trabajosCount=0;
        $tareasCount=0;


        while ($row = mysqli_fetch_array($query)) {
            $totalCount=$this->getTotalTrabajosTareas($row['id_modulo'])[0];
            $trabajosCount=$this->getCountTrabajos($_SESSION['user'],$row['id_modulo'])[0];
            $tareasCount=$this->getCountTareas($_SESSION['user'],$row['id_modulo'])[0];
            $percentage = $totalCount > 0 ? 
            (100 * ($trabajosCount + $tareasCount)) / $totalCount : 
            100;
            if ($count == 1) 
                $cardHtml = $cardHtml . "<div class=\"row\" style=\"align-content: center;\">";
            $cardHtml = $cardHtml .
                    "<div id=\"mod_".$row['id_modulo']."\" class=\"col-sm px-5 py-5 mx-3 my-3\" style=\"background-color: white;\">
                        <div class=\"p-1\">
                            <h2>" . $row['nombre_modulo'] . "</h1>
                            <h4>" . $row['descripcion'] . "</h4>
                            <p>".$percentage."% completado</p>
                            <button id=\"but_mod_".$row['id_modulo']."\" type=\"button\" onclick=\"showModuleHtml(this);\" class=\"btn btn-primary\" style=\"width: 120px; text-align: left;\">
                            Entrar<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button>
                        </div>
                    </div>";
            if ($count == 3) {
                $cardHtml = $cardHtml ."</div>";
                $count = 0;
            }
            $count++;
        }
        if ($count != 0) {
            $cardHtml = $cardHtml . "</div>";
        }

        return $cardHtml;
    }

    private function getTotalTrabajosTareas($moduleId){
        return mysqli_fetch_array($this->connect()->query('SELECT COUNT(*) FROM tareas_modulos 
        INNER JOIN trabajos_modulos ON tareas_modulos.id_modulo = trabajos_modulos.id_modulo 
        WHERE tareas_modulos.id_modulo IN (SELECT id_modulo FROM modulos WHERE id_modulo = '.$moduleId.')')); 
    }

    private function getCountTareas($username, $moduleId){
        return mysqli_fetch_array($this->connect()->query('SELECT COUNT(id_tarea) FROM tareas_usuarios WHERE revisado = 3 
        AND id_tarea IN (SELECT id_tarea FROM tareas_modulos WHERE id_modulo = '.$moduleId.') 
        AND id_usuario IN (SELECT id FROM usuarios WHERE login_user = \''.$username.'\')'));
    }

    private function getCountTrabajos($username, $moduleId){
        return mysqli_fetch_array($this->connect()->query('SELECT COUNT(id_trabajo) FROM trabajos_usuarios WHERE revisado = 3 
        AND id_trabajo IN (SELECT id_trabajo FROM trabajos_modulos WHERE id_modulo = '.$moduleId.')
        AND id_usuario IN (SELECT id FROM usuarios WHERE login_user = \''.$username.'\')'));
    }
}

?>