<?php
session_start();
include("connection.php");
$con = connect();
$username = $_POST["username"];
$password = $_POST["password"];
$sql = sprintf("SELECT * FROM Usuarios where login_user='".$username.
"' and login_pass='".$password."'");
$query = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) > 0) {
    $_SESSION['loginUser'] = $user['login_user'];
    $_SESSION['name'] = $user['nombre'];
    $_SESSION['lastname'] = $user['apellidos'];
    header('Location:../html/index.html');
}
else {
    header('Location:../html/login.html');
}


?>