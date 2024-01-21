<?php

include_once('coaching.php');
$coaching = new Coaching();
switch ($_GET['type']) {
    case 1:
        echo isset($_GET['coachingId']) ? $coaching->retrieveCoachings($_GET['user'], $_GET['coachingId']) : $coaching->retrieveCoachings($_GET['user']);
        break;
    case 2:
        echo $coaching->createCoaching($_GET['userId'], file_get_contents("php://input"));
        break;
    case 3:
        echo $coaching->updateCoaching($_GET['userId'], file_get_contents("php://input"));
        break;
    case 4:
        echo $coaching->deleteCoaching($_GET['userId'], $_GET['coachingId']);
        break;
}