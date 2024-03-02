<?php

include_once('settingsModel.php');
include_once('groups.php');
$settings = new Settings($_GET['userId']);
$groups = new Groups();

if (isset($_GET['data'])) {
    switch ($_GET['data']) {
        case 'payments':
            break;
        case 'get':
            switch ($_GET['dataType']) {
                case 'groups':
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($groups->prepareGroupsJson(), JSON_UNESCAPED_UNICODE);
                    break;
                case 'group':
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($groups->prepareSingleGroupJson(), JSON_UNESCAPED_UNICODE);
                    break;
                default:
                    http_response_code(404);
                    break;
            }
            break;
        case 'insert':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($groups->createGroup(), JSON_UNESCAPED_UNICODE);
            break;
        case 'update':
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($groups->updateGroup(), JSON_UNESCAPED_UNICODE);
            break;
        default:
            http_response_code(404);
            break;
    }
}