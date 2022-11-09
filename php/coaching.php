<?php

include_once('connection.php');

class Coaching extends DB
{

    public function retrieveCoachings($user)
    {
        $conn=(new DB())->connect();
        $query = $this->connect()->query('SELECT * FROM coaching WHERE id_usuario IN (SELECT id_usuario FROM usuarios WHERE login_user = \''.$user.'\') ORDER BY fecha_subida ASC') or die($conn->error);
        $html = "";

        while ($row = mysqli_fetch_array($query)) {
            $html = $html . "<tr><td scope=\"row\">" . $row['adjunto'] . "</td>";
            $html = $html . "<td>" . $row['fecha_subida'] . "</td>";
            $html = $html . '<td><a id="but_coaching_'.$row['id'].'" href="resources/templates/" download="'.$row['adjunto'].'"><img src="img/download.png" class="dashboard_icon m-2" title="Descargar tarea"></a></td></tr>';
        }

        return $html;
    }
}

?>