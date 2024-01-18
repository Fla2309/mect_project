<?php

include_once('files.php');

$file = new Files($_FILES['file'], $_POST['type'], $_POST['userId'], $_POST['activityId']);
$file->uploadAndRegisterFile();