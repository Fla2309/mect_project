<html lang="en">

<head>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.scss">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <title>Portal administrador</title>
</head>

<body>
    <?php include_once('view/navbar.php') ?>
    <script src="../js/admin.js" type="text/javascript"></script>
    <table hidden="true">
        <tr>
            <td><input type="text" placeholder="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
        </tr>
    </table>
    <div class="row">
        <div style="width: auto;">
            <ul class="nav nav-pills mb-1 flex-column">
                <li id="inicioNavItem" class="nav-item active">
                    <a class="nav-link active" title="Inicio" data-bs-target="#inicio" data-bs-toggle="tab"><img
                            src="../img/home.png" class="left_bar_icon"></a>
                </li>
                <li id="gruposNavItem" class="nav-item ">
                    <a class="nav-link " title="Grupos" data-bs-target="#grupos" data-bs-toggle="tab"><img
                            src="../img/group.png" class="left_bar_icon"></a>
                </li>
                <li id="usuariosNavItem" class="nav-item">
                    <a class="nav-link" title="Usuarios" data-bs-target="#usuarios" data-bs-toggle="tab"><img
                            src="../img/user_b.png" class="left_bar_icon"></a>
                </li>
                <li id="modulosNavItem" class="nav-item">
                    <a class="nav-link" title="Módulos" data-bs-target="#modulos" data-bs-toggle="tab"><img
                            src="../img/book.png" class="left_bar_icon"></a>
                </li>
                <li id="coachingNavItem" class="nav-item">
                    <a class="nav-link" title="Coachings" data-bs-target="#coaching" data-bs-toggle="tab"><img
                            src="../img/coaching.png" class="left_bar_icon"></a>
                </li>
                <li id="presentacionesNavItem" class="nav-item">
                    <a class="nav-link" title="Presentaciones" data-bs-target="#presentaciones"
                        data-bs-toggle="tab"><img src="../img/presentation.png" class="left_bar_icon"></a>
                </li>
                <li id="examenesNavItem" class="nav-item">
                    <a class="nav-link" title="Exámenes" data-bs-target="#examen" data-bs-toggle="tab"><img
                            src="../img/test.png" class="left_bar_icon"></a>
                </li>
            </ul>
        </div>
        <table hidden="true">
            <tr>
                <td><input type="text" placeholder="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
            </tr>
        </table>
        <div class="tab-content" style="background-color: #e2e2e2; width: calc(100% - 88px); height: auto;">
            <div class="tab-pane fade show active" style="margin: 1rem;" id="inicio">
                <h2 style="padding: 2rem;">Bienvenid@,
                    <?php echo $_SESSION['pref_name'] ?>
                </h2>
                <div class="row w-100">
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Grupos</h4>
                            <small><a class="nav-link col-md-1" onclick="goToTab(this)" href="#grupos">Ir→</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <hr class="divider">
                                <h5>Buscar grupo</h5>
                                <div class="row mt-3" id="groupSelects">
                                    <?php
                                    include_once('./php/dashboard.php');
                                    $dashboard = new Dashboard();
                                    echo $dashboard->generateGroupsFrame($_SESSION['nivel_usuario']);
                                    ?>
                                </div>
                                <div class="list-group mb-3" id="groupsFrame">
                                    <?php
                                    echo $dashboard->generateValidGroupsFrame('');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Módulos</h4>
                            <small><a class="nav-link col-md-1" onclick="goToTab(this)" href="#modulos">Ir→</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <hr class="divider">
                                <?php
                                echo $dashboard->generateModulesFrame($_SESSION['user'], true);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Presentaciones</h4>
                            <small><a class="nav-link col-md-1" onclick="goToTab(this)"
                                    href="#presentaciones">Ir→</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <hr class="divider">
                                <?php
                                echo $dashboard->generatePresentationsFrame($_SESSION['user'], true);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../js/group.js" type="text/javascript"></script>
            <div class="tab-pane fade show" id="grupos">
                <?php
                include_once('./php/groups.php');
                $moduleClass = new Groups();
                echo ($moduleClass)->retrieveGroups();
                ?>
            </div>
            <div class="tab-pane fade" id="usuarios">
                <div class="px-2 py-2 mx-2 my-2">
                    <div class="px-3 py-3" style="background-color: white;">
                        <h1 class="mb-3">Usuarios Registrados</h1>
                        <hr class="divider">
                        <div class="col-4 mb-3 d-flex">
                            <div class="col-7" id="controlPanel">
                                <input class="form-control" type="text" id="txtUser"
                                    onkeyup="searchInList('txtUser','usersList')" placeholder="Buscar por nombre..."
                                    title="Escribe el nombre">
                            </div>
                            <div class="col-5 ms-4">
                                <button type="button" class="btn btn-primary">Agregar Usuario</button>
                            </div>
                        </div>
                        <div class="row mt-3 col-4" id="groupSelects">
                            <?php
                            include_once('./php/dashboard.php');
                            $dashboard = new Dashboard();
                            echo $dashboard->generateGroupsFrame($_SESSION['nivel_usuario']);
                            ?>
                        </div>
                        <?php
                        include_once('./php/users.php');
                        $userGroup = new Users($_SESSION['user']);
                        echo $userGroup->prepareHtmlUsuarios($userGroup->getUsuarios());
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="modulos">Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos
                Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos
                Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos
                Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos
                Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos Módulos
                Módulos </div>

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
    <?php include_once('view/footer.html') ?>
</body>

</html>