<?php

include_once('settingsModel.php');
$settings = new Settings($_GET['userId']);
$user = $settings->saveSettings();
$_SESSION['user'] = $user->login_user;
$_SESSION['pref_name'] = $user->nombre_preferido;
$_SESSION['grupo'] = $user->id_pl;
$_SESSION['nivel_usuario'] = $user->nivel_usuario;


?>