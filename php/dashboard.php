<?php
include_once('connection.php');
class Dashboard
{
    function generateModulesFrame($group)
    {
        $html = "";
        $conn = (new DB())->connect();
        $query = $conn->query('SELECT * FROM modulos WHERE id_modulo IN 
        (SELECT id_modulo FROM modulos_grupos WHERE id_grupo = '.$group.' AND disponible > 0)') or die($conn->error);
        while ($row = mysqli_fetch_array($query)) {
            $html = $html . '<a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" role="tab" aria-controls="home">'.$row['nombre_modulo'].'</a>';        
        }
        return $html;
    }

    function generateCoachingFrame($username)
    {
        $html = "";
        $conn = (new DB())->connect();
        $query = $conn->query('SELECT * FROM coaching WHERE id_usuario IN 
        (SELECT id FROM usuarios WHERE login_user = \''.$username.'\') ORDER BY fecha_subida ASC') or die($conn->error);
        while ($row = mysqli_fetch_array($query)) {
            $html = $html . '<a class="list-group-item list-group-item-action" id="coaching_'.$row['id'].'" data-toggle="list" 
            role="tab" aria-controls="home">'.$row['adjunto'].'<small class="text-muted col-3">Subido: ' . $row['fecha_subida'] . 
            '</small><button id=\"but_coaching_'.$row['id'].'\" type=\"button\" onclick=\"showModuleHtml(this);\" style=\"width: 120px; text-align: left;\">
            <img src="../img/download.png" class="dashboard_icon"></button></a>';;        
        }
        return $html;
    }

    function generatePresentationsFrame()
    {

    }
}

?>