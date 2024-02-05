<?php

session_start();
include_once('../php/user.php');
include_once('../php/groupModel.php');
if ($_SESSION['user'] != $_GET['user'] && $_SESSION['nivel_usuario'] < 2) {
    include('unavailable.php');
} else {
    $currentUser = new User();
    $currentUser->setUser($_GET['user']);
    $currentUserGroup = new UserGroup(null, $currentUser->getUserGroup());
    $currentUserGroup->setGroup();
    $currentUserProcess = new UserProcess($currentUser->getUserId());
    $currentUserProcess->setUserProcess();
    $currentUserWeb = new UserWeb($currentUser->getUserId());
    $currentUserWeb->setUserWeb();
}
?>
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
    <style>
        body {
            background-color: #e2e2e2;
        }

        .card .card-header {
            background-color: #01176f;
            color: #ffffff;
        }

        hr.divider {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .profile_pic {
            border: .3rem solid #01176f;
            border-radius: 50%;
            height: 15rem;
            width: 15rem;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <title>Perfil Académico</title>
</head>

<body>
    <?php include_once('navbar.php') ?>
    <div class="text-center mt-5 mb-3">
        <img id="profilePic" class="img-fluid profile_pic mb-3" src="../<?php echo $currentUserWeb->getProfilePic() ?>"
            alt="Foto de Perfil">
        <h1 id="userName">
            <?php echo $currentUser->getFullName() ?>
        </h1>
    </div>
    <div class="m-3 mt-5">
        <div class="d-flex justify-content-center">
            <ul class="nav nav-pills mb-3 bg-white rounded p-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn nav-link active" id="pills-informacion-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-informacion" type="button" role="tab" aria-controls="pills-informacion"
                        aria-selected="true">Información</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-modulos-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-modulos" type="button" role="tab" aria-controls="pills-modulos"
                        aria-selected="false">Módulos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-examenes-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-examenes" type="button" role="tab" aria-controls="pills-examenes"
                        aria-selected="false">Exámenes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-pagos-tab" data-bs-toggle="pill" data-bs-target="#pills-pagos"
                        type="button" role="tab" aria-controls="pills-pagos" aria-selected="false">Pagos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-modulo-personal-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-modulo-personal" type="button" role="tab"
                        aria-controls="pills-modulo-personal" aria-selected="false">Módulo
                        Personal</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-presentaciones-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-presentaciones" type="button" role="tab"
                        aria-controls="pills-presentaciones" aria-selected="false">Presentaciones</button>
                </li>
            </ul>
        </div>
        <div class="tab-content w-100 d-flex justify-content-center" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-informacion" role="tabpanel"
                aria-labelledby="pills-informacion-tab">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mt-2">Información Personal</h3 class="mt-2">
                    </div>
                    <div class="card-body row">
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Nombre</h5>
                            <p class="card-text mt-2 m-b3" id="userName">
                                <?php echo $currentUser->getFullName() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Nombre Preferido</h5>
                            <p class="card-text mt-2 m-b3" id="userPrefName">
                                <?php echo $currentUser->getPreferredName() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Fecha de Ingreso</h5>
                            <p class="card-text mt-2 m-b3" id="userEnrollDate">
                                <?php echo $currentUser->getUserRegistrationDate() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Correo</h5>
                            <p class="card-text mt-2 m-b3" id="userMail">
                                <?php echo $currentUser->getUserMail() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Teléfono</h5>
                            <p class="card-text mt-2 m-b3" id="userPhone">
                                <?php echo $currentUser->getUserPhone() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Estado de Usuario</h5>
                            <p class="card-text mt-2 m-b3" id="userStatus">
                                <?php echo $currentUser->getUserStatus() == 0 ?
                                    'Activo <span class="position-absolute p-2 bg-primary border border-light rounded-circle"><span class="visually-hidden">Activo</span></span>' :
                                    'Inactivo <span class="position-absolute p-2 bg-danger border border-light rounded-circle"><span class="visually-hidden">Inactivo</span></span>' ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h3 class="mt-2">Información MECT</h3 class="mt-2">
                    </div>
                    <div class="card-body row">
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Grupo de MECT</h5>
                            <p class="card-text mt-2 m-b3" id="userGroup">
                                <?php echo $currentUserGroup->getGroupId() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Nombre del grupo</h5>
                            <p class="card-text mt-2 m-b3" id="userGroupName">
                                <?php echo $currentUserGroup->getGroupName() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Fecha de Comienzo</h5>
                            <p class="card-text mt-2 m-b3" id="userGroupStartDate">
                                <?php echo $currentUserGroup->getGroupStartDate() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Fecha de Terminación</h5>
                            <p class="card-text mt-2 m-b3" id="userGroupEndDate">
                                <?php echo $currentUserGroup->getGroupEndDate() ?>
                            </p>
                        </div>
                        <div class="col-3 mt-3">
                            <h5 class="card-title">Sede</h5>
                            <p class="card-text mt-2 m-b3" id="userGroupLocation">
                                <?php echo $currentUserGroup->getGroupLocation() ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-modulos" role="tabpanel" aria-labelledby="pills-modulos-tab">
                <div>
                    <h2>No hay información para mostrar</h2>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-examenes" role="tabpanel" aria-labelledby="pills-examenes-tab">
                <div>
                    <h2>No hay información para mostrar</h2>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-pagos" role="tabpanel" aria-labelledby="pills-pagos-tab">
                <div>
                    <h2>No hay información para mostrar</h2>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-modulo-personal" role="tabpanel"
                aria-labelledby="pills-modulo-personal-tab">
                <div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h3 class="mt-2">Información del Proceso Transformacional</h3 class="mt-2">
                        </div>
                        <div class="card-body row">
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Básico/Bloque 1</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessB1">
                                    <?php echo $currentUserProcess->getB1() ?>
                                </p>
                            </div>
                            <hr class="divider mt-3">
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Avanzado/Bloque 2</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessB2">
                                    <?php echo $currentUserProcess->getB2() ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Contrato</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessContract">
                                    <?php echo $currentUserProcess->getContract() ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Estiramiento en Avanzado/Bloque 2</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessTrainingB2">
                                    <?php echo $currentUserProcess->getTrainingb2() ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Canción de Cuna de Avanzado/Bloque 2</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessTrainingB2">
                                    <?php echo $currentUserProcess->getSongB2() ?>
                                </p>
                            </div>
                            <hr class="divider mt-3">
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Programa de Liderazgo/Acciona y Materializa</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessPL">
                                    <?php echo $currentUserProcess->getAm() ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Fuente</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessSource">
                                    <?php echo $currentUserProcess->getSourceOf() ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Estiramiento en PL/AM</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessTrainingPL">
                                    <?php echo $currentUserProcess->getTrainingAm() ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Canción de Cuna de Tercer Fin</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessTrainingPL">
                                    <?php echo $currentUserProcess->getSongAm() ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-presentaciones" role="tabpanel"
                aria-labelledby="pills-presentaciones-tab">
                <div>
                    <h2>No hay información para mostrar</h2>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('footer.html') ?>
</body>

</html>