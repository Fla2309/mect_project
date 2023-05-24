<?php

include_once('settingsModel.php');
$settings = new Settings($_GET['userId']);

switch ($_GET['type']) {
    case 0:
        $user = $settings->saveSettings();
        $_SESSION['user'] = $user->login_user;
        $_SESSION['pref_name'] = $user->nombre_preferido;
        $_SESSION['grupo'] = $user->id_pl;
        $_SESSION['nivel_usuario'] = $user->nivel_usuario;
        break;
    case 1:
        $settings->savePassword($_GET['userId'], $_GET['currentPass'], $_GET['newPass']);
        break;
    case 2:
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($settings->getPersonalModuleDocuments($_GET['userId']));
        http_response_code(201);
        break;
    default:
        http_response_code(404);
        break;
}


?>