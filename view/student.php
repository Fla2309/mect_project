<html>

<head>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <title>Portal del alumno</title>
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
                            <a href="view/settings.php" class="dropdown-item">Configuración</a>
                            <a href="../php/logout.php" class="dropdown-item">Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <table hidden="true">
            <tr>
                <td><input type="text" placeholder="<?php echo $_SESSION['user']?>" class="user_properties"></td>
            </tr>
        </table>

    <div class="row">
        <div style="width: auto;">
            <ul class="nav nav-pills mb-1 flex-column">
                <li class="nav-item active">
                    <a class="nav-link active" title="Inicio" href="#inicio" data-bs-toggle="tab"><img
                            src="../img/home.png" class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Módulos" href="#modulos" data-bs-toggle="tab"><img src="../img/book.png"
                            class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Coaching" href="#coaching" data-bs-toggle="tab"><img
                            src="../img/coaching.png" class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Presentaciones" href="#presentaciones" data-bs-toggle="tab"><img
                            src="../img/presentation.png" class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Exámenes" href="#examen" data-bs-toggle="tab"><img src="../img/test.png"
                            class="left_bar_icon"></a>
                </li>
            </ul>
        </div>
        <div class="tab-content" style="background-color: #e2e2e2; width: calc(100% - 88px); height: auto;">
            <div class="tab-pane fade show active" style="margin: 1rem;" id="inicio">
                <h2 style="padding: 2rem;">Bienvenido(a),
                    <?php echo $_SESSION['pref_name']?>
                </h2>
                <div class="row w-100">
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11">Módulos Activos</h4>
                            <small><a class="nav-link col-md-1" style="font-family: IBM Plex Sans;" data-bs-toggle="tab" href="#modulos">Ir→</a></small>
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
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11">Coaching Recientes</h4>
                            <small><a class="nav-link col-md-1" style="font-family: IBM Plex Sans;" data-bs-toggle="tab" href="#coaching">Ir→</a></small>
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
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11">Presentaciones</h4>
                            <small><a class="nav-link col-md-1" style="font-family: IBM Plex Sans;" data-bs-toggle="tab" href="#presentaciones">Ir→</a></small>
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

            <div class="tab-pane fade" id="coaching">
                <div class="mx-3 my-5" style="background-color: white">
                <h2 class="px-3 py-3">Coachings Registrados</h2>
                <hr class="divider">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">Nombre del archivo</th>
                        <th scope="col">Fecha de subida</th>
                        <th scope="col"></th>
                    </thead>
                    <tbody>
                    <?php
include_once('./php/coaching.php');
$moduleClass = new Coaching();
echo ($moduleClass)->retrieveCoachings($_SESSION['user']);
?>
                    </tbody>
                </table>
                </div>
            </div>
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