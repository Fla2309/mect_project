<?php
include_once('connection.php');
include_once('feedback.php');
class Dashboard
{
    private $conn;
    public function __construct()
    {
        $this->conn = (new DB())->connect();
    }
    function generateModulesFrame($group, $admin = false)
    {
        $html = "";
        $query = $admin ?
            $this->conn->query('SELECT * FROM modulos') :
            $this->conn->query('SELECT * FROM modulos WHERE id_modulo IN 
            (SELECT id_modulo FROM modulos_grupos WHERE id_grupo = ' .
                $group . ' AND disponible > 0)') or die($this->conn->error);
        while ($row = mysqli_fetch_array($query)) {
            $html = $html . '<a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" role="tab" aria-controls="home">' . $row['nombre_modulo'] . '</a>';
        }
        return $html;
    }

    function generateCoachingFrame($userId)
    {
        $html = "";
        $query = $this->conn->query("SELECT * FROM coaching_usuarios WHERE id_usuario IN 
        (SELECT id FROM usuarios WHERE id_usuario = {$userId}) ORDER BY fecha DESC LIMIT 5") or die($this->conn->error);
        while ($row = mysqli_fetch_array($query)) {
            $html = $html . "<a class=\"list-group-item list-group-item-action align-items-center\" id=\"dashCoaching_{$row['id']}\" data-toggle=\"list\" role=\"tab\" aria-controls=\"home\"><em>{$row['nombre_coaching']}</em> con <em>{$row['nombre_coachee']}</em>";
            $html = $html . "<div class=\"d-flex justify-content-end\">";
            $html = $html . "<div class=\"pr-2\">";
            $html = $html . "<small class=\"text-muted\" style=\"font-size: 10px\">Subido: {$row['fecha']}'";
            $html = $html . "</small></div></div></a>";
        }
        return $html;
    }

    function generatePresentationsFrame($username, $admin = false)
    {
        $html = "";
        $query = $admin ?
            $this->conn->query('SELECT presentaciones_feedback.id, usuarios.nombre, usuarios.apellidos, presentaciones_feedback.nombre_feedback, presentaciones_feedback.autor, presentaciones_feedback.fecha_subido 
            FROM presentaciones_feedback, usuarios WHERE presentaciones_feedback.id_usuario = usuarios.id ORDER BY fecha_subido ASC') :
            $this->conn->query('SELECT * FROM presentaciones_feedback WHERE id_usuario IN 
            (SELECT id FROM usuarios WHERE login_user = \'' . $username . '\') ORDER BY fecha_subido ASC') or die($this->conn->error);
        while ($row = mysqli_fetch_array($query)) {
            $html = $admin ?
                $html . "<a class=\"list-group-item list-group-item-action align-items-center\" id=\"presentation_{$row['id']}\" data-toggle=\"list\" 
                    role=\"tab\" aria-controls=\"home\">{$row['nombre_feedback']}<br>Presentador: {$row['nombre']} {$row['apellidos']}<div class=\"d-flex justify-content-between\">" :
                $html . '<a class="list-group-item list-group-item-action align-items-center" id="presentation_' . $row['id'] . '" data-toggle="list" 
                    role="tab" aria-controls="home">' . $row['nombre_feedback'] . '<div class="d-flex justify-content-between">';
            $html = $html . '<div class="pr-2"><small class="text-muted" style="font-size: 10px">Autor: ' . $row['autor'] . '</small></div>';
            $html = $html . '<div class="pr-2"><small class="text-muted" style="font-size: 10px">Subido: ' . $row['fecha_subido'] . '</small></div></div></a>';
        }
        return $html;
    }

    function generateGroupsFrame($userLevel)
    {
        if ($userLevel < 1) {
            echo 'Usuario no autorizado para esta información';
            return;
        }

        $groups = [];
        $years = [];
        $regions = [];
        $html = '';

        $query = $this->conn->query('SELECT * FROM grupos') or die($this->conn->error);
        while ($row = mysqli_fetch_array($query)) {
            array_push($groups, $row['nombre_grupo']);

            $region = $row['sede'];
            if (array_search($region, $regions) === false)
                array_push($regions, $region);

            $year = explode('-', $row['fecha_inicio'])[0];
            if (array_search($year, $years) === false)
                array_push($years, $year);
        }

        //regiones
        $html = $html . '<div class="col-8 mb-3">';
        $html = $html . '<select class="form-select" aria-label="Regions" id="region">';
        $html = $html . '<option selected="selected">Region...</option>';
        foreach ($regions as $region)
            $html = $html . '<option value="' . $region . '">' . $region . '</option>';
        $html = $html . '</select>';
        $html = $html . '</div>';

        //años
        $html = $html . '<div class="col-4 mb-3">';
        $html = $html . '<select class="form-select" aria-label="Years" id="year">';
        $html = $html . '<option selected="selected">Año...</option>'; foreach ($years as $year)
            $html = $html . '<option value="' . $year . '">' . $year . '</option>';
        $html = $html . '</select>';
        $html = $html . '</div>';

        //grupos
        $html = $html . '<div class="col-12 mb-3">';
        $html = $html . '<select class="form-select" aria-label="Groups" id="group">';
        $html = $html . '<option selected="selected">Grupo...</option>'; foreach ($groups as $group)
            $html = $html . '<option value="' . $group . '">' . $group . '</option>';
        $html = $html . '</select>';
        $html = $html . '</div>';

        return $html;
    }

    function generateValidGroupsFrame($args)
    {
        $query = $args === '' ?
            $this->conn->query("SELECT * FROM grupos") :
            $this->conn->query("SELECT * FROM grupos where " . $args);
        $html = '';
        while ($row = mysqli_fetch_array($query)) {
            $html = $html . "<a href=\"#\" id=gr_\"{$row['id_grupo']}\" class=\"list-group-item list-group-item-action\" aria-current=\"true\">";
            $html = $html . '<div class="d-flex w-100 justify-content-between">';
            $html = $html . "<h5 class=\"mb-1\">MECT {$row['id_grupo']} {$row['nombre_grupo']}</h5>";
            $html = $html . "</div>";
            $html = $html . "<p class=\"mb-1\">{$row['sede']}</p>";
            $html = $html . "<small class=\"text-muted\">Fecha de inicio: {$row['fecha_inicio']}</small>";
            $html = $html . "</a>";
        }
        return $html;
    }

    function generateFeedbackFrame($userId, $admin = false)
    {
        $feedbackData = (new Feedback($userId))->retrieveFeedbackDashboard();
        $html = '';
        foreach ($feedbackData as $row) {
            $html = $html . "<div class=\"accordion-item\"><h2 class=\"accordion-header\" id=\"feedback_{$row['id']}\">";
            $html = $html . "<button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#collapse_{$row['id']}\" aria-expanded=\"false\" aria-controls=\"collapse_{$row['id']}\">";
            $html = $html . "{$row['module_name']}<span class=\"text-black-50\">({$row['date']})</span></button></h2>";
            $html = $html . "<div id=\"collapse_{$row['id']}\" class=\"accordion-collapse collapse\" aria-labelledby=\"heading_{$row['id']}\" data-bs-parent=\"#feedback-accordion\">";
            $html = $html . "<div class=\"accordion-body\"><small class=\"text-muted\">{$row['feedback']}</small><br><strong>Autor: </strong>{$row['author']}";
            $html = $html . "<small><a class=\"nav-link text-primary\" onclick=\"goToTab(this)\" href=\"#modulos\">Ir al feedback→</a></small></div></div></div>";
        }

        return $html;
    }
}

?>