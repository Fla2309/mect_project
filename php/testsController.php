<?php

include_once('testsModel.php');
$tests = new Tests($_GET['userId']);

switch ($_GET['type']) {
    case 0:
        $rows = $tests->retrieveTestsPerUser();
        $html = "";
        foreach ($rows as $row) {
            $resultColor = $row['resultado'] >= 70 ? "text-success" : "text-danger";
            $html = $html . '<a class="list-group-item list-group-item-action align-items-center" id="test_' . $row['id'] . '" data-toggle="list" role="tab" aria-controls="home"><p class="fw-bold">' . $row['nombre'] . '</p>';
            $html = $html . '<div class="d-flex justify-content-between">';
            $html = $html . '<div class="pr-2 d-flex"> Calificación: <p class="fw-bold ' . $resultColor . '">' . $row['resultado'] . '</p></div>';
            $html = $html . '<div class="pr-2"><small class="text-muted" style="font-size: 10px">Terminado: ' . $row['fecha_aplicacion'] . '</small></div></div></a>';
        }
        echo $html;
        break;
    case 1:
        $rows = $tests->retrieveActiveTestPerGroup();
        $html = "";
        foreach ($rows as $row) {
            $html = $html . "<div id=\"active_test_" . $row['id_examen'] . "\" class=\"col-sm px-1 py-1\" style=\"background-color: white;\">";
            $html = $html . "<div class=\"p-1\">";
            $html = $html . "<h2>" . $row['nombre'] . "</h1>";
            $html = $html . "<h4>" . $row['comentarios'] . "</h4>";
            $html = $html . "<a href=\"" . $row['liga'] . "\"><button id=\"but_active_test_" . $row['id_examen'] . "\" type=\"button\" class=\"btn btn-primary\" style=\"width: auto; text-align: left;\">";
            $html = $html . "Ir al examen<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button></a>";
            $html = $html . "</div>";
            $html = $html . "</div>";
        }
        echo $html;
        break;
    case 3:
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tests->retrieveTestsAdmin());
        break;
    default:
        break;
}

?>