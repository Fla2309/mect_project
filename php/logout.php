<?php

try{unset($_SESSION["session_id"]);} catch(Exception $e){}

include_once("session.php");
$session = new Session;
$session->closeSession();
header("location:../");

?>