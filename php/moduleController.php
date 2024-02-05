<?php

include_once('modules.php');
$module = new Module();

if ($module->userLevel > 1) {
    if (!isset($_GET['data'])) {
        if (isset($_GET['dataType'])) {
            $userModule = new UserModule();
            switch ($_GET['dataType']) {
                case 'works':
                    echo json_encode($userModule->prepareTrabajosJson());
                    break;
                case 'homeworks':
                    echo json_encode($userModule->prepareTareasJson());
                    break;
                case 'all':
                    $module = [
                        'works' => $userModule->prepareTrabajosJson(),
                        'homeworks' => $userModule->prepareTareasJson(),
                    ];
                    echo json_encode($module);
                    break;
            }
        } else if (isset($_GET['actId'])) {
            header('Content-Type: application/json; charset=utf-8');
            $data = $module->getModuleActivitiesDetails($_GET['type'], $_GET['actId']);
            echo json_encode($data);
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($module->retrieveModules(), JSON_UNESCAPED_UNICODE);
        }
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
} else {
    if (isset($_GET['dataType'])) {
        $userModule = new UserModule();
        switch ($_GET['dataType']) {
            case 'works':
                echo json_encode($userModule->prepareTrabajosJson());
                break;
            case 'homeworks':
                echo json_encode($userModule->prepareTareasJson());
                break;
            case 'feedback':
                echo json_encode($userModule->prepareFeedbackJson());
            case 'all':
                $moduleTabs = [
                    'works' => $userModule->prepareTrabajosJson(),
                    'homeworks' => $userModule->prepareTareasJson(),
                    'feedback' => $userModule->prepareFeedbackJson()
                ];
                echo json_encode($moduleTabs);
                break;
        }
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($module->retrieveModules(), JSON_UNESCAPED_UNICODE);
    }
}