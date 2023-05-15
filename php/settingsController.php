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
    default:
        break;
}


?>