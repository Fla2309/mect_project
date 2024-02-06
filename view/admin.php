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
    <title>Portal
        <?php
        switch ($_SESSION['userType']) {
            case 2:
                echo 'Observador';
                break;
            case 3:
                echo 'Administrador';
                break;
            case 4:
                echo 'Master Coach';
                break;
        }
        ?>
    </title>
</head>

<body>
    <?php include_once('view/navbar.php') ?>
    <script src="../js/admin.js" type="text/javascript"></script>
    <table hidden="true">
        <tr>
            <td><input type="text" id="user" placeholder="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
            <td><input type="text" id="userName" placeholder="<?php echo $_SESSION['userName'] ?>"
                    class="user_properties"></td>
            <td><input type="text" id="userId" placeholder="<?php echo $_SESSION['userId'] ?>"
                    value="<?php echo $_SESSION['userId'] ?>" class="user_properties"></td>
        </tr>
    </table>
    <div class="row g-0">
    <!-- <div class="d-flex align-items-start"> -->
        <div style="width: 55px;" class="col-auto">
            <ul class="nav nav-pills mb-1 flex-column">
                <li id="inicioNavItem" class="nav-item active">
                    <a class="nav-link active" title="Inicio" data-bs-target="#inicio" data-bs-target="#inicio"
                        data-bs-toggle="tab"><img src="../img/home.png" class="left_bar_icon"></a>
                </li>
                <li id="gruposNavItem" class="nav-item">
                    <a class="nav-link " title="Grupos" onclick="generateUsersPage()" data-bs-target="#grupos" data-bs-toggle="tab"><img
                            src="../img/group.png" class="left_bar_icon"></a>
                </li>
                <li id="usuariosNavItem" class="nav-item">
                    <a class="nav-link" title="Usuarios" onclick="generateUsersPage()" data-bs-target="#usuarios"
                        data-bs-toggle="tab"><img src="../img/user_b.png" class="left_bar_icon"></a>
                </li>
                <li id="modulosNavItem" class="nav-item">
                    <a class="nav-link" title="Módulos" onclick="generateModulesPage()" data-bs-target="#modulos"
                        data-bs-toggle="tab"><img src="../img/book.png" class="left_bar_icon"></a>
                </li>
                <li id="examenesNavItem" class="nav-item">
                    <a class="nav-link" title="Exámenes" onclick="loadTestsPage()" data-bs-target="#examen"
                        data-bs-toggle="tab"><img src="../img/test.png" class="left_bar_icon"></a>
                </li>
            </ul>
        </div>
        <!-- <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#grupos"
                type="button" role="tab" aria-controls="v-pills-home" aria-selected="true"><img src="../img/home.png"
                    class="left_bar_icon"></button>
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#grupos"
                type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false"><img
                    src="../img/group.png" class="left_bar_icon"></button>
            <button class="nav-link" onclick="generateUsersPage()" data-bs-toggle="pill" data-bs-target="#usuarios"
                type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false"><img
                    src="../img/user_b.png" class="left_bar_icon"></button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#modulos"
                type="button" role="tab" onclick="generateModulesPage()" aria-selected="false"><img
                    src="../img/book.png" class="left_bar_icon"></button>
            <button class="nav-link" onclick="loadTestsPage()" data-bs-toggle="pill" data-bs-target="#examen"
                type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false"><img
                    src="../img/test.png" class="left_bar_icon"></button>
        </div> -->
        <div class="tab-content col-auto" style="background-color: #e2e2e2; width: calc(100% - 88px); height: auto;">
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
                // include_once('./php/groups.php');
                // $moduleClass = new Groups();
                // echo ($moduleClass)->retrieveGroups();
                ?>
            </div>
            <div class="tab-pane fade" id="usuarios">
                <div class="px-2 py-2 mx-2 my-2">
                    <div class="px-3 py-3" style="background-color: white;" id="usersDetails">
                        <h1 class="mb-3">Usuarios Registrados</h1>
                        <hr class="divider">
                        <div class="col-4 mb-3 d-flex">
                            <div class="col-7" id="usersControlPanel">
                                <input class="form-control" type="text" id="txtUser"
                                    onkeyup="searchInList('txtUser','usersList')" placeholder="Buscar por nombre..."
                                    title="Escribe el nombre">
                            </div>
                            <div class="col-5 ms-4">
                                <button type="button" onclick="clearAndShowSettingsModal()"
                                    class="btn btn-primary">Agregar Usuario</button>
                            </div>
                        </div>
                        <!-- <div class="row mt-3 col-4" id="groupSelectsUsers">
                            //<?php
                            //include_once('./php/dashboard.php');
                            //$dashboard = new Dashboard();
                            //echo $dashboard->generateGroupsFrame($_SESSION['nivel_usuario']);
                            //?>
                        </div> -->

                    </div>
                </div>
            </div>
            <script src="../js/moduleAdmin.js" type="text/javascript"></script>
            <div class="tab-pane fade" id="modulos">

            </div>
            <script src="../js/testAdmin.js" type="text/javascript"></script>
            <div class="tab-pane fade" id="examen">
                <div class="d-flex">
                    <div class="px-2 py-2 mx-2 my-2 col-6">
                        <div class="px-3 py-3" style="background-color: white;">
                            <h1 class="mb-3">Exámenes</h1>
                            <hr class="divider">
                            <div class="col-4 mb-3 d-flex">
                                <button type="button" class="btn btn-primary">Crear Examen</button>
                            </div>
                            <div class="accordion" id="testsAccordion">

                            </div>
                        </div>
                    </div>
                    <div class="px-2 py-2 mx-2 my-2 col-6">
                        <div class="px-3 py-3" style="background-color: white;">
                            <h1 class="mb-3">Búsqueda de exámenes</h1>
                            <hr class="divider">
                            <div class="col-4 mb-3 d-flex">
                                <div class="col-10" id="testsControlPanel">
                                    <input class="form-control" type="text" id="txtTest"
                                        onkeyup="searchInList('txtTest','testsList')" placeholder="Buscar por nombre..."
                                        title="Escribe el nombre">
                                </div>
                            </div>
                            <div class="row mt-3 col-7" id="groupSelectsTests">
                                <?php
                                $dashboard = new Dashboard();
                                echo $dashboard->generateGroupsFrame($_SESSION['nivel_usuario']);
                                ?>
                            </div>
                            <div class="list-group" id="testsList" role="tablist">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modals-->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Configuración del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userSettings">
                    <div class="input-group mb-2" hidden>
                        <span class="input-group-text bg-primary text-white">ID</span>
                        <input class="form-control" placeholder="Nombre" id="targetUserId">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nombre y Apellidos</span>
                        <input class="form-control" placeholder="Nombre" id="targetUserName">
                        <input class="form-control" placeholder="Apellidos" id="targetUserLastname">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nombre/Alias Preferido</span>
                        <input class="form-control" placeholder="Alias" id="targetUserPrefName">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Grupo de PL/AM</span>
                        <input class="form-control" placeholder="PL" id="targetUserPlId">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Grupo de MECT</span>
                        <select class="form-select" aria-label="Select module" id="groupsDropdown">
                            <?php
                            $moduleClass = new Groups();
                            echo $moduleClass->getGroupHtmlDropdownTags();
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Fecha de Ingreso MECT</span>
                        <input class="form-control" placeholder="(AAAA-MM-DD)" id="targetUserDate">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Correo</span>
                        <input class="form-control" placeholder="Correo" id="targetUserMail">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Teléfono</span>
                        <input class="form-control" placeholder="Teléfono" id="targetUserPhone">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Usuario web</span>
                        <input class="form-control" placeholder="usuario.web" id="targetUserLogin">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nivel de Usuario</span>
                        <select class="form-select" aria-label="Select module" id="levelsDropdown">
                            <?php
                            echo $moduleClass->getUserLevelHtmlDropdownTags();
                            ?>
                        </select>
                    </div>

                    <p id="errorAct" class="text-danger" hidden></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveNewUser()">Guardar
                        cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userSettings">
                    <div class="input-group mb-2" hidden>
                        <span class="input-group-text bg-primary text-white">ID</span>
                        <input class="form-control" placeholder="Nombre" id="targetUserIdPayment">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nombre y Apellidos</span>
                        <input class="form-control" placeholder="Nombre" id="targetUserNamePayment" disabled>
                        <input class="form-control" placeholder="Apellidos" id="targetUserLastnamePayment" disabled>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Correo</span>
                        <input class="form-control" placeholder="Correo" id="targetUserMailPayment" disabled>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Teléfono</span>
                        <input class="form-control" placeholder="Teléfono" id="targetUserPhonePayment" disabled>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Fecha del pago</span>
                        <input class="form-control" placeholder="AAAA-MM-DD" id="targetUserDatePayment" disabled>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Importe</span>
                        <span class="input-group-text">$</span>
                        <input class="form-control" placeholder="Importe" id="targetUserAmountPayment">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Concepto</span>
                        <input class="form-control" placeholder="Concepto" id="targetUserReasonPayment">
                    </div>
                    <p id="errorAct" class="text-danger" hidden></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="registerPayment()">Guardar
                        cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changesMadeModal" tabindex="-1" aria-labelledby="changesMadeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changesMadeModalLabel">Atención</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="changesMadeModalBody">

                </div>
            </div>
        </div>
    </div>
    <?php include_once('view/footer.html') ?>
</body>

</html>