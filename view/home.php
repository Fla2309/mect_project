<html>

<head>
    <link rel="stylesheet" href="../css/main.css">
    <!--<link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.css">-->
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <nav id="" class="nav_bar">
        <div class="form-inline">
            <a href="#"><img src="../img/logoMECT.png" id="nav_logo"></a>
            <form id="search_box">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar en el sitio..."
                    aria-label="Search">
                <button class="btn btn-outline-success" type="submit" style="color: #ffffff;">Buscar</button>
            </form>
            <!--<form class="nav_bar_icon_form">-->
            <!--<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex nav_bar_icon_form">
                <li><a href="#"><img src="../img/calendar.png" alt="" class="nav_bar_icon nav-item"></a></li>
                <li><img src="../img/notif.png" alt="" class="nav_bar_icon nav-item"></li>
                <li><img src="../img/user.png" alt="" class="nav_bar_icon nav-item"></li>
            </ul>-->


            <ul class="collapse navbar-collapse navbar-nav flex-row ml-md-auto d-none d-md-flex nav_bar_icon_form "
                style="position: absolute; right: 3%;">
                <li class="nav-item"><a href="#"><img src="../img/calendar.png" alt=""
                            class="nav_bar_icon nav-item"></a></li>
                <li class="nav-item"><img src="../img/notif.png" alt="" class="nav_bar_icon nav-item"></a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="../img/user.png" alt="" class="nav_bar_icon nav-item">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a href="#" class="dropdown-item">Módulo personal</a>
                        <a href="#" class="dropdown-item">Configuración de cuenta</a>
                        <a href="../php/logout.php" class="dropdown-item">Cerrar sesión</a>
                    </div>
                </li>
            </ul>

            <!--</form>-->
        </div>
    </nav>

    <div class="row">
        <div class="col-1">
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item active">
                    <a class="nav-link active" href="#inicio" data-toggle="tab">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modulos" data-toggle="tab">Módulos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#coaching" data-toggle="tab">Coaching</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#presentaciones" data-toggle="tab">Presentaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#examen" data-toggle="tab">Examen</a>
                </li>
            </ul>
        </div>
        <table hidden="true">
            <tr>
                <td><input type="text" placeholder="<?php echo $_SESSION['user']?>" class="user_properties"></td>
            </tr>
        </table>
        <div class="tab-content col-11" style="background-color: #e2e2e2; width: max-content; height: max-content">
            <div class="tab-pane fade show active" style="padding: 2rem; margin: 1rem;" id="inicio">
                <h1>Bienvenido, <?php echo $_SESSION['pref_name'] ?></h1>
            </div>
            <div class="tab-pane fade" id="modulos">
            <script src="../js/module.js" type="text/javascript"></script>
            <?php
            include_once('./php/modules.php');
            $_SESSION['grupo']=$user->getUserGroup();
            echo $_SESSION['user'];
            echo (new Module())->retrieveModules($_SESSION['grupo']);
            ?>
            <button id="but_mod_1" onclick="showModuleHtml(this);" type="button" class="btn btn-success" style="width: 120px; text-align: left;">
                                Entrar<img src="../img/right-arrow.png" style="float: right;" width="20"></button>
            </div>
            
            <div class="tab-pane fade" id="coaching">Coaching Coaching Coaching Coaching Coaching Coaching Coaching
                Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching
                Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching
                Coaching Coaching Coaching Coaching </div>
            <div class="tab-pane fade" id="presentaciones">Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones </div>
            <div class="tab-pane fade" id="examen">Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen
                Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen
                Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen
            </div>
        </div>
    </div>
</body>

</html>