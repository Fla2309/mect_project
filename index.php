<?php

include_once 'php/user.php';
include_once 'php/session.php';


$userSession = new Session();
$user = new User();

if(isset($_SESSION['session_id'])){
    //echo "Hay sesión";
    #$user->setUser($userSession->getCurrentUser());
    include_once 'view/home.php';
}else if(isset($_POST['username']) && isset($_POST['password'])){
    //echo "Validación de login";

    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    if($user->userExists($userForm, $passForm)){
        //echo "usuario validado";
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);
        $userSession->setCurrentUserFullname($user);
        $userSession->setCurrentUserPreferredName($user);
        $userSession->generateSessionId();

        include_once 'view/home.php';
    }else{
        //echo "nombre de usuario y/o password incorrecto";
        $errorLogin = "Nombre de usuario y/o contraseña es incorrecto";
        include_once 'view/login.php';
    }

}else{
    //echo "Login";
    include_once 'view/login.php';
}

?>