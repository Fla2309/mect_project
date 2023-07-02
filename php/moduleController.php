<?php

include_once('modules.php');
$module = new Module();

header('Content-Type: application/json; charset=utf-8');
$data = $module->getModuleActivitiesDetails($_GET['type'], $_GET['actId']);
echo json_encode($data);

?>