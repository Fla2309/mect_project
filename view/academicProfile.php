<?php
session_start();
include_once ('../php/user.php');
include_once ('../php/users.php');
include_once ('../php/groupModel.php');
include_once ('../php/modules.php');
if ($_SESSION['user'] != $_GET['user'] && $_SESSION['nivel_usuario'] < 2) {
    include ('unavailable.php');
} else {
    $currentUser = new User();
    $currentUser->setUser($_GET['user']);
    $currentUserGroup = new UserGroup(null, $currentUser->getUserGroup());
    $currentUserGroup->setGroup();
    $currentUserProcess = new UserProcess($currentUser->getUserId());
    $currentUserProcess->setUserProcess();
    $currentUserWeb = new UserWeb($currentUser->getUserId());
    $currentUserWeb->setUserWeb();
    $currentUserModules = new Module($currentUser->getUserId());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.scss">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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

        .progress {
            background-color: #e2e2e2;
            width: 5vw;
        }

        .list-group-item img {
            height: 2.5rem;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <?php if ($_SESSION['nivel_usuario'] > 1)
        echo '<script src="../js/admin.js"></script>'; ?>
    <title>Perfil Académico</title>
</head>

<body>
    <?php include_once ('navbar.php') ?>
    <table hidden>
        <tr>
            <td><input type="text" id="user" placeholder="<?php echo $_SESSION['user'] ?>"
                    value="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
            <td><input type="text" id="userName" placeholder="<?php echo $_SESSION['fullname'] ?>"
                    value="<?php echo $_SESSION['fullname'] ?>" class="user_properties"></td>
            <td><input type="text" id="userId" placeholder="<?php echo $_SESSION['userId'] ?>"
                    value="<?php echo $_SESSION['userId'] ?>" class="user_properties"></td>
        </tr>
    </table>
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
            <div class="tab-pane fade show active" style="width: inherit;" id="pills-informacion" role="tabpanel"
                aria-labelledby="pills-informacion-tab">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mt-2">Información Personal</h3 class="mt-2">
                    </div>
                    <div class="card-body row">
                        <div class="col-3 mt-3" hidden>
                            <h5 class="card-title">ID</h5>
                            <span class="card-text mt-2 m-b3" id="currentUserId"><?php echo $currentUser->getUserId() ?></span>
                        </div>
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
            <div class="tab-pane fade" style="width: inherit;" id="pills-modulos" role="tabpanel"
                aria-labelledby="pills-modulos-tab">
                <?php

                $modules = $currentUserModules->retrieveModules();
                $currentUserModuleActivities = null;
                $cardBody = '';
                $cardHeader = '';
                $card = '';
                if ($modules != []) {
                    foreach ($modules as $module) {
                        if ($module['progress'] < 25) {
                            $progressColorClass = 'bg-danger';
                        } else if ($module['progress'] >= 25 && $module['progress'] < 70) {
                            $progressColorClass = 'bg-warning';
                        } else if ($module['progress'] >= 70 && $module['progress'] < 100) {
                            $progressColorClass = 'bg-info';
                        } else if ($module['progress'] >= 100) {
                            $progressColorClass = 'bg-primary';
                        }
                        $currentUserModuleActivities = new ModuleDetails($module['moduleId']);
                        $userActivities = [];
                        $moduleActivitiesListString = '<h3>Trabajos</h3>';
                        $moduleHomeworksListString = '<h3 class="mt-3">Tareas</h3>';
                        $cardHeader =
                            '<div class="card-header d-flex justify-content-between">
                                <h3 class="mt-2 vh-50 col-auto">' . $module['moduleName'] . '</h3>
                                <div class="d-flex ms-3">
                                    <span class="align-self-center">Progreso:&nbsp;</span>
                                    <div class="progress align-self-center">
                                        <div class="progress-bar ' . $progressColorClass . ' progress-bar-striped" role="progressbar" style="width: ' . $module['progress'] . '%" aria-valuenow="' . $module['progress'] . '" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>';
                        $currentActivities = $currentUserModuleActivities->getActivities();
                        $count = 0;
                        if ($currentActivities) {
                            foreach ($currentActivities as $moduleActivity) {
                                /** @var ModuleActivity $moduleActivity */
                                $userModuleActivityDetails = $moduleActivity->getUserActivityDetails($currentUser->getUserId());
                                $statusElement = '';
                                if (!empty($userModuleActivityDetails)) {
                                    switch ($userModuleActivityDetails['actStatus']) {
                                        case 0:
                                            $statusElement = "<button class=\"btn btn-light disabled\"><strong>Pendiente</strong></button>";
                                            break;
                                        case 1:
                                            $statusElement = $_SESSION['nivel_usuario'] > 1 ?
                                                "<div class=\"dropdown\">
                                                    <button class=\"btn btn-warning dropdown-toggle\" type=\"button\" id=\"mod-{$module['moduleId']}_act-{$moduleActivity->getActivityId()}_review\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">Revisar</button>
                                                    <ul class=\"dropdown-menu\" aria-labelledby=\"mod-{$module['moduleId']}_act-{$moduleActivity->getActivityId()}_review\" id=\"mod-{$module['moduleId']}_act-{$moduleActivity->getActivityId()}_options\">
                                                        <li><a class=\"dropdown-item item-pass\" href=\"#\" data-value=\"pass\">Acreditar<i class=\"bi bi-check\"></i></a></li>
                                                        <li><a class=\"dropdown-item item-fail\" href=\"#\" data-value=\"fail\">Rechazar<i class=\"bi bi-x\"></i></a></li>
                                                    </ul>
                                                </div>" :
                                                "<button class=\"btn btn-warning disabled\"><strong>En revisión</strong></button>";
                                            break;
                                        case 2:
                                            $statusElement = "<button class=\"btn btn-danger disabled\"><strong>Rechazado</strong></button>";
                                            break;
                                        case 3:
                                            $statusElement = "<button class=\"btn btn-primary disabled\"><strong>Revisado</strong></button>";
                                            break;
                                    }
                                    $moduleActivitiesListString .=
                                        "<div class=\"d-flex mt-1\">
                                            <a class=\"list-group-item list-group-item-action\">
                                                <div id=\"mod-{$module['moduleId']}_act-{$moduleActivity->getActivityId()}\" class=\"d-flex w-100 justify-content-start\">
                                                    <h5 class=\"mb-1\">{$moduleActivity->activityName}</h5>
                                                </div>
                                            </a>
                                            <div class=\"d-flex justify-content-end\">{$statusElement}
                                                <a href=\"../{$currentUserWeb->getUserPath()}{$moduleActivity->type}s/{$userModuleActivityDetails['attachment']}\" download=\"{$userModuleActivityDetails['attachment']}\">
                                                    <img class=\"dashboard_icon m-2\" title=\"Descargar {$moduleActivity->activityName}\" src=\"../img/download.png\">
                                                </a>
                                            </div>
                                        </div>";
                                }
                            }
                        } else {
                            $moduleActivitiesListString .= "<h5>No hay trabajos para mostrar</h5>";
                        }
                        $currentHomeworks = $currentUserModuleActivities->getHomeworks();
                        if ($currentHomeworks) {
                            foreach ($currentHomeworks as $moduleActivity) {
                                /** @var ModuleActivity $moduleActivity */
                                $userModuleActivityDetails = $moduleActivity->getUserActivityDetails($currentUser->getUserId());
                                $statusElement = '';
                                if (!empty($userModuleActivityDetails)) {
                                    switch ($userModuleActivityDetails['actStatus']) {
                                        case 0:
                                            $statusElement = "<button class=\"btn btn-light disabled\"><strong>Pendiente</strong></button>";
                                            break;
                                        case 1:
                                            $statusElement = $_SESSION['nivel_usuario'] > 1 ?
                                                "<div class=\"dropdown\">
                                                <button class=\"btn btn-warning dropdown-toggle\" type=\"button\" id=\"mod-{$module['moduleId']}_hw-{$moduleActivity->getActivityId()}_review\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">Revisar</button>
                                                <ul class=\"dropdown-menu\" aria-labelledby=\"mod-{$module['moduleId']}_hw-{$moduleActivity->getActivityId()}_review\" id=\"mod-{$module['moduleId']}_hw-{$moduleActivity->getActivityId()}_options\">
                                                    <li><a class=\"dropdown-item item-pass\" href=\"#\" data-value=\"pass\">Acreditar<i class=\"bi bi-check\"></i></a></li>
                                                    <li><a class=\"dropdown-item item-fail\" href=\"#\" data-value=\"fail\">Rechazar<i class=\"bi bi-x\"></i></a></li>
                                                </ul>
                                            </div>" :
                                                "<button class=\"btn btn-warning disabled\"><strong>En revisión</strong></button>";
                                            break;
                                        case 2:
                                            $statusElement = "<button class=\"btn btn-danger disabled\"><strong>Rechazado</strong></button>";
                                            break;
                                        case 3:
                                            $statusElement = "<button class=\"btn btn-primary disabled\"><strong>Revisado</strong></button>";
                                            break;
                                    }
                                    $moduleHomeworksListString .=
                                        "<div class=\"d-flex mt-1\">
                                            <a class=\"list-group-item list-group-item-action\">
                                                <div id=\"mod{$module['moduleId']}_hw{$moduleActivity->getActivityId()}\" class=\"flex-grow-1 mb-1\">
                                                    <h5>{$moduleActivity->activityName}</h5>
                                                </div>
                                            </a>
                                            <div class=\"d-flex justify-content-end\">{$statusElement}
                                                <a href=\"../{$currentUserWeb->getUserPath()}{$moduleActivity->type}s/{$userModuleActivityDetails['attachment']}\" download=\"{$userModuleActivityDetails['attachment']}\">
                                                    <img class=\"dashboard_icon m-2\" title=\"Descargar {$moduleActivity->activityName}\" src=\"../img/download.png\">
                                                </a>
                                            </div>
                                        </div>";
                                }
                            }
                        } else {
                            $moduleHomeworksListString .= "<h5>No hay tareas para mostrar</h5>";
                        }
                        $cardBody =
                            '<div class="card-body row accordion g-0" id="accModule' . $module['moduleId'] . '">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="accHeading' . $module['moduleId'] . '">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapse' . $module['moduleId'] . '" aria-expanded="false" aria-controls="collapseOne">Ver contenido del módulo</button>
                                    </h2>
                                    <div id="accCollapse' . $module['moduleId'] . '" class="accordion-collapse collapsed collapse" aria-labelledby="accHeading' . $module['moduleId'] . '" data-bs-parent="#accModule' . $module['moduleId'] . '">
                                        <div class="accordion-body" id="accBody"' . $module['moduleId'] . '>
                                            ' . $moduleActivitiesListString . '<hr class=\"divider\">' . $moduleHomeworksListString . '
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        echo '<div class="card mt-2">' . $cardHeader . $cardBody . '</div>';
                    }
                } else {
                    echo '<h2>No hay información para mostrar</h2>';
                }

                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        document.querySelectorAll('.dropdown-item').forEach(item => {
                            item.addEventListener('click', (event) => {
                                event.preventDefault();
                                const value = event.target.getAttribute('data-value');
                                const ulElement = event.target.closest('ul.dropdown-menu');
                                reviewActivity(value, ulElement.id);
                            });
                        });
                    });
                </script>
            </div>
            <div class="tab-pane fade" style="width: inherit;" id="pills-examenes" role="tabpanel"
                aria-labelledby="pills-examenes-tab">
                <div>
                    <h2>No hay información para mostrar</h2>
                </div>
            </div>
            <div class="tab-pane fade" style="width: inherit;" id="pills-pagos" role="tabpanel"
                aria-labelledby="pills-pagos-tab">
                <?php

                $payments = (new Users($_SESSION['userId']))->preparePagosArray($currentUser->getUserId());
                $cardBody = '';
                $cardHeader = '';
                $card = '';
                if ($payments != []) {
                    foreach ($payments as $payment) {
                        $cardBody .=
                            '<li class="list-group-item d-flex justify-content-start" id="payment_0">
                                <div class="col-auto align-self-center"><img src="../img/payment.png" title="Pagos" class="img-fluid me-3"></div>
                                <div class="col-auto align-items-center"> 
                                    <p>
                                        <strong>Concepto: </strong>' . $payment['reason'] . '&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Importe: </strong>' . $payment['amount'] . '&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Fecha: </strong>' . $payment['paymentDate'] . '<br>
                                        <strong>Teléfono: </strong>' . $payment['phone'] . '&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Correo: </strong>' . $payment['email'] . '
                                    </p>
                                </div>
                            </li>';
                    }
                    $cardHeader = '<div class="card-header"><h3 class="mt-2 vh-50 col-auto">Pagos Registrados</h3></div>';
                    $cardBody = '<div class="card-body" id="payment' . $payment['paymentId'] . '"><ul class="list-group">' . $cardBody . '</ul></div>';
                    $card = '<div class="card mt-2">' . $cardHeader . $cardBody . '</div>';
                    echo $card;
                } else {
                    echo '<h2>No hay información para mostrar</h2>';
                }

                ?>
            </div>
            <div class="tab-pane fade" style="width: inherit;" id="pills-modulo-personal" role="tabpanel"
                aria-labelledby="pills-modulo-personal-tab">
                <div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h3 class="mt-2">Documentos de Usuario</h3 class="mt-2">
                        </div>
                        <div class="card-body row">
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Currículum</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessB1">
                                    <?php echo $currentUserWeb->getCv() != null ?
                                        "{$currentUserWeb->getCv()}<a href=\"../{$currentUserWeb->getUserPath()}documentos/{$currentUserWeb->getCv()}\" download=\"{$currentUserWeb->getCv()}\" id=\"download-resume\">
                                        <img src=\"../img/download.png\" title=\"Descargar documento\" class=\"dashboard_icon ms-2\" alt=\"Descargar\"></a>" :
                                        'No hay documentos para mostrar' ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Formato de inscripción</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessB2">
                                    <?php echo $currentUserWeb->getInscription() != null ? "{$currentUserWeb->getInscription()}<a href=\"../{$currentUserWeb->getUserPath()}documentos/{$currentUserWeb->getInscription()}\" download=\"{$currentUserWeb->getInscription()}\" id=\"download-registration\">
                                        <img src=\"../img/download.png\" title=\"Descargar documento\" class=\"dashboard_icon ms-2\" alt=\"Descargar\"></a>" :
                                        'No hay documentos para mostrar' ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Identificación (parte frontal)</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessContract">
                                    <?php echo $currentUserWeb->getIdFront() != null ? "{$currentUserWeb->getIdFront()}<a href=\"../{$currentUserWeb->getUserPath()}documentos/{$currentUserWeb->getIdFront()}\" download=\"{$currentUserWeb->getIdFront()}\" id=\"download-id-front\">
                                        <img src=\"../img/download.png\" title=\"Descargar documento\" class=\"dashboard_icon ms-2\" alt=\"Descargar\"></a>" :
                                        'No hay documentos para mostrar' ?>
                                </p>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 class="card-title">Identificación (parte trasera)</h5>
                                <p class="card-text mt-2 m-b3" id="userProcessTrainingB2">
                                    <?php echo $currentUserWeb->getIdBack() != null ? "{$currentUserWeb->getIdBack()}<a href=\"../{$currentUserWeb->getUserPath()}documentos/{$currentUserWeb->getIdBack()}\" download=\"{$currentUserWeb->getIdBack()}\" id=\"download-id-back\">
                                        <img src=\"../img/download.png\" title=\"Descargar documento\" class=\"dashboard_icon ms-2\" alt=\"Descargar\"></a>" :
                                        'No hay documentos para mostrar' ?>
                                </p>
                            </div>
                        </div>
                    </div>
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
                                <p class="card-text mt-2 m-b3" id="userProcessB2Song">
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
                                <p class="card-text mt-2 m-b3" id="userProcessPLSong">
                                    <?php echo $currentUserProcess->getSongAm() ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" style="width: inherit;" id="pills-presentaciones" role="tabpanel"
                aria-labelledby="pills-presentaciones-tab">
                <div>
                    <h2>No hay información para mostrar</h2>
                </div>
            </div>
        </div>
    </div>

    <?php include_once ('footer.html') ?>
</body>

</html>