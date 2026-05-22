<?php
include_once('notifications.php');
if (!isset($_SESSION['grupo']))
    $_SESSION['grupo'] = $user->getUserGroup();
if (!isset($_SESSION['nivel_usuario']))
    $_SESSION['nivel_usuario'] = $user->getUserLevel();
if (!isset($_SESSION['foto_perfil']))
    $_SESSION['foto_perfil'] = $user->getUserProfilePic();
$notifications = isset($_SESSION['userId']) ? new Notifications($_SESSION['userId']) : new Notifications($user->getUserId());
$_SESSION['global_notifications'] = $notifications->getGlobalNotifications();
$_SESSION['notifications'] = $notifications->getUserNotifications();
switch ($_SESSION['nivel_usuario']) {
    case 1:
        include_once "view/student.php";
        break;
    case 2:
    case 3:
    case 4:
        include_once "view/admin.php";
        break;
    default:
        $errorLogin = "El usuario ingresado no está autorizado";
        include_once 'view/login.php';
        break;
}
