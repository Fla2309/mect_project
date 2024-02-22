<?php

include_once('settingsModel.php');
include_once('groups.php');
$settings = new Settings($_GET['userId']);

if (isset($_GET['data'])) {
    switch ($_GET['data']) {
        case 'payments':
            break;
        case 'get':
            switch ($_GET['dataType']) {
                case 'groups':
                    $groups = new Groups();
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($groups->prepareGroupsJson());
                    break;
                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'insert':
            $groups = new Groups();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($groups->createGroup());
            break;
        default:
            http_response_code(404);
            break;
    }
}