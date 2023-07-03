<?php

include_once('modules.php');
$module = new Module();

if (!isset($_GET['data'])) {
    header('Content-Type: application/json; charset=utf-8');
    $data = $module->getModuleActivitiesDetails($_GET['type'], $_GET['actId']);
    echo json_encode($data);
} else {
    switch ($_GET['data']) {
        case 'delete':
            $module->deleteActivityFromModule($_GET['type'], $_GET['actId']);
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
        default:
            break;
    }
}

?>