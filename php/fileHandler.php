<?php

include_once('files.php');

switch ($_POST['type']) {
    case 'work':
    case 'homework':
        $file = new Files();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($file->uploadAndRegisterFile(), JSON_UNESCAPED_UNICODE);
        break;
    case 'document':
        $document = new Documents();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($document->uploadAndRegisterDocument(), JSON_UNESCAPED_UNICODE);
        break;
}