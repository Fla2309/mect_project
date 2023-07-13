<?php

include_once('settingsModel.php');
$settings = new Settings($_GET['userId']);

if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 0:
            $user = $settings->saveSettings();
            $_SESSION['pref_name'] = $user->nombre_preferido;
            break;
        case 1:
            $settings->savePassword($_GET['userId'], $_GET['currentPass'], $_GET['newPass']);
            break;
        case 2:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($settings->getPersonalModuleDocuments($_GET['userId']));
            break;
        case 3:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($settings->setProfilePicture($_GET['userId'], $_GET['pictureName'], file_get_contents('php://input')));
            break;
        case 4:
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($settings->retrieveSettings($_GET['targetUser']));
            break;
            case 5:
                $user = $settings->saveSettings();
                //echo json_encode($user);
                break;
        default:
            http_response_code(404);
            break;
    }
}


?>