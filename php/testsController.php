<?php

include_once('testsModel.php');
$tests = null;
if (isset($_GET['userId'])) {
    $tests = new Tests($_GET['userId']);
}
if (isset($_POST['userId'])) {
    $tests = new Tests($_POST['userId']);
}

if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 0:
            // $rows = $tests->retrieveTestsPerUser();
            // $html = "";
            // foreach ($rows as $row) {
            //     $resultColor = $row['resultado'] >= 70 ? "text-success" : "text-danger";
            //     $html = $html . '<a class="list-group-item list-group-item-action align-items-center" id="test_' . $row['id'] . '" data-toggle="list" role="tab" aria-controls="home"><p class="fw-bold">' . $row['nombre'] . '</p>';
            //     $html = $html . '<div class="d-flex justify-content-between">';
            //     $html = $html . '<div class="pr-2 d-flex"> Calificación: <p class="fw-bold ' . $resultColor . '">' . $row['resultado'] . '</p></div>';
            //     $html = $html . '<div class="pr-2"><small class="text-muted" style="font-size: 10px">Terminado: ' . $row['fecha_aplicacion'] . '</small></div></div></a>';
            // }
            // echo $html;
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->retrieveTestsPerUser());
            break;
        case 1:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->retrieveActiveTestPerGroup());
            break;
        case 2:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->retrieveAvailableGroups());
            break;
        case 3:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->retrieveTestsAdmin());
            break;
        case 4:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->retrieveExamsAdmin());
            break;
        default:
            break;
    }
}

if (isset($_GET['data'])) {
    switch ($_GET['data']) {
        case 'availableTests':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->getAvailableTestsByGroup());
            break;
        case 'setExamByGroup':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->setExamByGroup());
            break;
        case 'activateExam':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->setExamStatus(1));
            break;
        case 'closeExam':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->setExamStatus(2));
            break;
        case 'startExamStudent':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->startExamStudent());
            break;
        case 'getExamQuestions':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->getExamQuestions());
            break;
        case 'finishExam':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tests->finishExam());
            break;
        default:
            break;
    }
}