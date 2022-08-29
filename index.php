<?php

include_once 'php/user.php';
include_once 'php/session.php';


$userSession = new Session();
$user = new User();

if(isset($_SESSION['session_id'])){
    include_once 'view/home.php';
}else if(isset($_POST['username']) && isset($_POST['password'])){
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    if($user->userExists($userForm, $passForm)){
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);
        $userSession->setCurrentUserFullname($user);
        $userSession->setCurrentUserPreferredName($user);
        $userSession->generateSessionId();

        include_once 'view/home.php';
    }else{
        $errorLogin = "Nombre de usuario y/o contraseña es incorrecto";
        include_once 'view/login.php';
    }

}else{
    include_once 'view/login.php';
}

?>