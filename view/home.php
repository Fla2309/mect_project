<?php
if(!isset($_SESSION['grupo']))
$_SESSION['grupo']=$user->getUserGroup();
?>

<html>

<head>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="nav_bar">
        <div class="form-inline">
            <a href=""><img src="../img/logoMECT.png" id="nav_logo"></a>
            <form id="search_box">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar en el sitio..."
                    aria-label="Search">
                <button class="btn btn-outline-success" type="submit" style="color: #ffffff;">Buscar</button>
            </form>

            <ul class="collapse navbar-collapse navbar-nav flex-row ml-md-auto d-none d-md-flex nav_bar_icon_form "
                style="position: absolute; right: 3%;">
                <li class="nav-item"><a href="#"><img src="../img/calendar.png" alt=""
                            class="nav_bar_icon nav-item"></a></li>
                <li class="nav-item"><img src="../img/notif.png" alt="" class="nav_bar_icon nav-item"></a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="../img/user.png" alt="" class="nav_bar_icon nav-item">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a href="#" class="dropdown-item">Módulo personal</a>
                        <a href="#" class="dropdown-item">Configuración</a>
                        <a href="../php/logout.php" class="dropdown-item">Cerrar sesión</a>
                    </div>
                </li>
            </ul>

            <!--</form>-->
        </div>
    </nav>

    <div class="row w-100">
        <div class="left_bar">
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item active">
                    <a class="nav-link active" href="#inicio" data-toggle="tab"><img src="../img/home.png"
                            class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modulos" data-toggle="tab"><img src="../img/book.png"
                            class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#coaching" data-toggle="tab"><img src="../img/coaching.png"
                            class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#presentaciones" data-toggle="tab"><img src="../img/presentation.png"
                            class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#examen" data-toggle="tab"><img src="../img/test.png"
                            class="left_bar_icon"></a>
                </li>
            </ul>
        </div>
        <table hidden="true">
            <tr>
                <td><input type="text" placeholder="<?php echo $_SESSION['user']?>" class="user_properties"></td>
            </tr>
        </table>
        <div class="tab-content" style="background-color: #e2e2e2; min-width: 97% !important;">
            <div class="tab-pane fade show active" style="margin: 1rem;" id="inicio">
                <h2 style="padding: 2rem;">Bienvenido(a),
                    <?php echo $_SESSION['pref_name'] ?>
                </h2>
                <div class="row w-100">
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="form-inline align-items-center" style="margin: 0">
                            <h4>Módulos Activos</h4>
                            <small><a class="nav-link" data-toggle="tab" href="#modulos">Ir →</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <?php
                            include_once('./php/dashboard.php');
                            echo (new Dashboard)->generateModulesFrame($_SESSION['grupo']);
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="form-inline align-items-center" style="margin: 0">
                            <h4>Coaching Recientes</h4>
                            <small><a class="nav-link" data-toggle="tab" href="#coaching">Ir →</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <?php
                            echo (new Dashboard)->generateCoachingFrame($_SESSION['user']);
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="form-inline align-items-center" style="margin: 0">
                            <h4>Presentaciones</h4>
                            <small><a class="nav-link" data-toggle="tab" href="#presentaciones">Ir →</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <?php
                                echo (new Dashboard)->generatePresentationsFrame($_SESSION['user']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="modulos">
                <script src="../js/module.js" type="text/javascript"></script>
                <?php
            include_once('./php/modules.php');
            $moduleClass = new Module();
            echo ($moduleClass)->retrieveModules($_SESSION['grupo']);
            ?>
            </div>

            <div class="tab-pane fade" id="coaching">Coaching Coaching Coaching Coaching Coaching Coaching Coaching
                Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching
                Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching Coaching
                Coaching Coaching Coaching Coaching </div>
            <div class="tab-pane fade" id="presentaciones">Presentaciones Presentaciones Presentaciones
                Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones
                Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones Presentaciones
                Presentaciones
                Presentaciones </div>
            <div class="tab-pane fade" id="examen">Examen Examen Examen Examen Examen Examen Examen Examen Examen
                Examen
                Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen
                Examen
                Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen Examen
                Examen
            </div>
        </div>
    </div>
</body>

</html>