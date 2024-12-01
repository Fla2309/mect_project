<?php

include_once('presentationsModel.php');
$userId = isset($_POST['userId']) ? $_POST['userId'] : $_GET['userId'];
$presentations = new Presentations($userId);

switch ($_GET['type']) {
    case 'getFeedback':
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($presentations->getPresentationsFeedbackPerUser(), JSON_UNESCAPED_UNICODE);
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