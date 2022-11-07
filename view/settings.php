<?php



?>

<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/admin.js"></script>
    <title>Configuración de cuenta</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg" id="nav_bar">
        <div class="container-fluid">
            <a href="/index.php" class="navbar-brand"><img src="../img/fridamental_banner1.png" id="nav_logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex"
                    style="display: inline-block; margin-left: auto; margin-right: auto; text-align: left;"
                    role="search">
                    <input class="form-control me-2" type="search" placeholder="Buscar en el sitio..."
                        aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit" style="color: #ffffff;">Buscar</button>
                </form>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="position: absolute; right: 1%;">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="../img/calendar.png" title="Calendario" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><img src="../img/notif.png" title="Notificaciones" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="userDropdown" title="Menú de usuario" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../img/user.png" alt="" class="nav_bar_icon nav-item">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <a href="#" class="dropdown-item">Módulo personal</a>
                            <a href="../view/settings.php" class="dropdown-item">Configuración</a>
                            <a href="../php/logout.php" class="dropdown-item">Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>