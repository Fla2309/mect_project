<?php
function connect()
{
    $server="192.168.100.16";
    $user="admin";
    $pass="secret";
    $db="mect_dev";
    $conn = mysqli_connect($server, $user, $pass);
    if (!$conn){
        die("No hay conexión a la base de datos".mysqli_connect_error());
    }
    mysqli_select_db($conn, $db);
    #mysql_query("SET NAME 'utf8'");
    return $conn;
}
?>