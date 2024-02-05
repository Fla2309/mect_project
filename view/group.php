<?php
include_once('../php/groupModel.php');
session_start();
$userGroup = new UserGroup($_GET['user'], $_GET['group']);
?>

<html lang="en">

<head>
</head>

<body>
    <button type="button" class="btn btn-primary" onclick="reloadGroups()"><img src="../img/left-arrow.png" width="20">
        Volver</button>
    <div class="px-2 py-2 mx-2 my-2">
        <div class="card">
            <div class="card-header">
                <h2>
                    <?php echo $userGroup->getGroupIdAndNameString(); ?>
                </h2>
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#usuarios" data-bs-toggle="tab">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modulos" data-bs-toggle="tab">Módulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pagos" data-bs-toggle="tab">Pagos</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane card-body active" id="usuarios">
                    <div class="col-4 mb-3 d-flex">
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtGroupUser" onkeyup="searchInList('txtGroupUser','groupUsersList')"
                                placeholder="Buscar..." title="Escribe el nombre">
                        </div>
                        <div class="col-5 ms-4">
                            <button type="button" class="btn btn-primary">Agregar Usuario</button>
                        </div>
                    </div>
                    <div id="usersDiv">
                        <?php
                        echo $userGroup->prepareHtmlUsuarios($userGroup->getUsuariosByGroup())
                            ?>
                    </div>
                    <div id="usersRighPanel" class="col-9" hidden="true">

                    </div>
                </div>
                <div class="tab-pane card-body" id="modulos">
                    <div class="col-4 mb-3">
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtGroupModule" onkeyup="searchInList('txtGroupModule','groupModulesList')"
                                placeholder="Buscar..." title="Escribe el nombre">
                        </div>
                    </div>
                    <?php
                    echo $userGroup->prepareHtmlModulos($userGroup->getModulosByGroup());
                    ?>
                </div>
                <div class="tab-pane card-body" id="pagos">
                    <div class="col-4 mb-3 d-flex">
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtGroupPayment" onkeyup="searchInList('txtGroupPayment','groupPaymentsList')"
                                placeholder="Buscar..." title="Escribe el nombre">
                        </div>
                        <div class="col-5 ms-4">
                            <button type="button" class="btn btn-primary">Registrar Pago</button>
                        </div>
                    </div>
                    <?php
                    echo $userGroup->prepareHtmlPagos($userGroup->getPagosByGroup());
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>