<?php

include_once('coaching.php');
$coaching = new Coaching();
switch ($_GET['type']) {
    case 1:
        echo isset($_GET['coachingId']) ? $coaching->retrieveCoachings($_GET['user'], $_GET['coachingId']) : $coaching->retrieveCoachings($_GET['user']);
        break;
    case 2:
        break;
    case 3:
        break;
    case 4:
        break;
}