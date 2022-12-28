<?php

include_once('dashboard.php');

header('Content-Type: text/html; charset=utf-8');
$dashboard = new Dashboard;
if (!isset($_GET['region']) && !isset($_GET['year']) && !isset($_GET['group'])){
    echo $dashboard->generateValidGroupsFrame('');
    return;
}
$fields = [
    0 => array('region=', 'sede=\''),
    1 => array('year=', 'fecha_inicio>\''),
    2 => array('group=', 'nombre_grupo=\'')
];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$url = isset($_GET['region']) ? utf8_decode(str_replace($fields[0][0], $fields[0][1], $url)) : utf8_decode($url);
$url = isset($_GET['group']) ? utf8_decode(str_replace($fields[2][0], $fields[2][1], $url)) : utf8_decode($url);
if (isset($_GET['year'])) {
    $url = str_replace($_GET['year'], '', $url);
    $url = str_replace($fields[1][0], $fields[1][1] . $_GET['year'] . '-01-01\' AND fecha_inicio<\'' . ++$_GET['year'] . '-01-01', $url);
}
$args = explode('&', $url);
$query = implode("' AND ", $args).'\'';
echo utf8_encode($dashboard->generateValidGroupsFrame($query));
return;
?>