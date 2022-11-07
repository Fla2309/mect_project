<?php
if(!isset($_SESSION['grupo']))
    $_SESSION['grupo']=$user->getUserGroup();
if(!isset($_SESSION['nivel_usuario']))
    $_SESSION['nivel_usuario']=$user->getUserLevel();
switch($_SESSION['nivel_usuario']){
    case 1:
        include_once "view/student.php";
        break;
    case 2:
        include_once "view/admin.php";
        break;
    default:
}
    
?>