<?php

include_once("session.php");
$session = new Session;
$session->closeSession();
http_response_code(200);
header("location:../");

?>