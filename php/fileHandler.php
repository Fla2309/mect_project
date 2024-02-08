<?php

include_once('files.php');

$file = new Files();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($file->uploadAndRegisterFile(), JSON_UNESCAPED_UNICODE);