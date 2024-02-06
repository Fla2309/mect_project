<?php

include_once('users.php');
include_once('user.php');
$users = new Users($_GET['userId']);

switch ($_GET['data']) {
    case 'get':
        if (isset($_GET['dataType'])) {
            switch ($_GET['dataType']) {
                case 'payments':
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($users->preparePagosArray($_GET['targetUser']), JSON_UNESCAPED_UNICODE);
                    break;
                case 'paymentInfo':
                    echo $users->getUserPaymentInfo();
                    break;
                case 'userLogin':
                    $targetUserWeb = new UserWeb($_GET['targetUserId']);
                    $targetUserWeb->setUserWeb();
                    echo $targetUserWeb->getUserLogin();
                    break;
            }
        } else {
            echo $users->prepareUsuariosJson();
        }
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
        if (isset($_GET['dataType'])) {
            switch ($_GET['dataType']) {
                case 'payments':
                    echo $users->registerPaymentForUser();
                    break;
            }
        } else {
            $values = [
                'actName' => $_GET['actName'],
                'moduleId' => $_GET['moduleId'],
                'templateName' => $_GET['templateName'],
                'comments' => $_GET['comments']
            ];
            $module->createActivityFromModule($_GET['type'], $values);
        }
        break;
    default:
        break;
}


?>