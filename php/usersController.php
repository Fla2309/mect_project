<?php

include_once('users.php');
$users = new Users($_GET['userId']);

switch ($_GET['data']) {
    case 'get':
        echo $users->prepareUsuariosJson();
        break;
    case 'delete':
        $users->deleteUser($_GET['targetUser']);
        break;
    case 'update':
        $values = [
            'actName' => $_GET['actName'],
            'moduleId' => $_GET['moduleId'],
            'templateName' => $_GET['templateName'],
            'comments' => $_GET['comments']
        ];
        $module->updateActivityFromModule($_GET['type'], $_GET['actId'], $values);
        break;

    case 'create':
        $values = [
            'actName' => $_GET['actName'],
            'moduleId' => $_GET['moduleId'],
            'templateName' => $_GET['templateName'],
            'comments' => $_GET['comments']
        ];
        $module->createActivityFromModule($_GET['type'], $values);
        break;
    case 'payments':
        echo $users->prepareHtmlPagos($_GET['targetUser']);
        break;
    default:
        break;
}


?>