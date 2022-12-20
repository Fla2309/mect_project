<html lang="en">

<head>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
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
    <title>Portal administrador</title>
</head>

<body>
    <?php include_once('view/navbar.php') ?>
    <div class="row">
        <div style="width: auto;">
            <ul class="nav nav-pills mb-1 flex-column">
                <li class="nav-item active">
                    <a class="nav-link active" title="Inicio" href="#inicio" data-bs-toggle="tab"><img
                            src="../img/home.png" class="left_bar_icon"></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " title="Grupos" href="#grupos" data-bs-toggle="tab"><img src="../img/group.png"
                            class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Usuarios" href="#modulos" data-bs-toggle="tab"><img
                            src="../img/user_b.png" class="left_bar_icon"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Módulos" href="#coaching" data-bs-toggle="tab"><img src="../img/book.png"
                            class="left_bar_icon"></a>
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
                            <h4 class="col-md-11">Grupos</h4>
                            <small><a class="nav-link col-md-1" style="font-family: IBM Plex Sans;" data-bs-toggle="tab"
                                    href="#modulos">Ir→</a></small>
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
                                    <div class="list-group mb-3" id="groupsFrame">
                                        <?php
                                        echo $dashboard->generateValidGroupsFrame('');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11">Módulos</h4>
                            <small><a class="nav-link col-md-1" style="font-family: IBM Plex Sans;" data-bs-toggle="tab"
                                    href="#coaching">Ir→</a></small>
                        </div>
                        <div class="px-3 py-2">
                            <div class="list-group" id="list-tab" role="tablist">
                            <hr class="divider">
                                <?php
                                echo (new Dashboard)->generateModulesFrame($_SESSION['user'], true);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11">Presentaciones</h4>
                            <small><a class="nav-link col-md-1" style="font-family: IBM Plex Sans;" data-bs-toggle="tab"
                                    href="#presentaciones">Ir→</a></small>
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
            <div class="tab-pane fade show" id="grupos">
                <?php
                include_once('./php/groups.php');
                $moduleClass = new Groups();
                echo ($moduleClass)->retrieveGroups();
                ?>
            </div>
            <div class="tab-pane fade" id="modulos">
                <!--<?php
                include_once('./php/modules.php');
                $moduleClass = new Module();
                echo ($moduleClass)->retrieveModules($_SESSION['grupo']);
                ?>-->
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