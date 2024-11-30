<?php

include_once('presentationsModel.php');
$userId = isset($_POST['userId']) ? $_POST['userId'] : $_GET['userId'];
$presentations = new Presentations($userId);

switch ($_GET['type']) {
    case 'getFeedback':
        $rows = $presentations->getPresentationsFeedbackPerUser();
        $html = "";
        foreach ($rows as $row) {
            $html = $html . "<tr><td scope=\"row\">" . $row['nombre_feedback'] . "</td>";
            $html = $html . "<td>" . $row['autor'] . "</td>";
            $html = $html . "<td>" . $row['fecha_subido'] . "</td>";
            $html = $html . '<td><a id="but_presentation_' . $row['id'] . '" href="resources/templates/" download="' . $row['archivo'] . '"><img src="img/download.png" class="dashboard_icon m-2" title="Descargar tarea"></a></td></tr>';
        }
        echo $html;
        break;
    case 'setTopic':
        $presentations->savePresentationTopicByUserId();
        break;
    case 'setFeedback':
        $presentations->savePresentationFeedbackByUserId();
        break;
    default:
        break;
}