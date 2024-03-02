<?php
include_once('../php/groupModel.php');
session_start();
$userGroup = new UserGroup($_GET['user'], $_GET['group']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <button type="button" class="btn btn-primary ms-3 mt-3 p-2" onclick="reloadGroups()"><img
            src="../img/left-arrow.png" width="20">
        Volver a Grupos</button>
    <div class="p-2 m-2" id="groupId_<?php echo $userGroup->getGroupId() ?>">
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
                    <div class="col mb-3 d-flex">
                        <div class="col-5" id="controlPanel">
                            <input class="form-control" type="text" id="txtGroupUser"
                                onkeyup="searchInList('txtGroupUser','groupUsersList')" placeholder="Buscar..."
                                title="Escribe el nombre">
                        </div>
                        <div class="col ms-4">
                            <button type="button" title="Por Implementar" class="btn btn-primary"
                                data-bs-toggle="offcanvas" data-bs-target="#addUsersOffcanvas"
                                aria-controls="addUsersOffcanvas"><img src="../img/plus.png"
                                    width="20">&nbsp;Añadir</button>
                        </div>
                    </div>
                    <div id="usersDiv">
                        <?php
                        echo $userGroup->prepareHtmlUsuarios($userGroup->getUsuariosByGroup())
                            ?>
                    </div>
                </div>
                <div class="tab-pane card-body" id="modulos">
                    <div class="col-4 mb-3">
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtGroupModule"
                                onkeyup="searchInList('txtGroupModule','groupModulesList')" placeholder="Buscar..."
                                title="Escribe el nombre">
                        </div>
                    </div>
                    <?php
                    echo $userGroup->prepareHtmlModulos($userGroup->getModulosByGroup());
                    ?>
                </div>
                <div class="tab-pane card-body" id="pagos">
                    <div class="col-4 mb-3 d-flex">
                        <div class="col-7" id="controlPanel">
                            <input class="form-control" type="text" id="txtGroupPayment"
                                onkeyup="searchInList('txtGroupPayment','groupPaymentsList')" placeholder="Buscar..."
                                title="Escribe el nombre">
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addUsersOffcanvas" aria-labelledby="addUsersOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="addUsersOffcanvasLabel">Añadir Usuarios al Grupo</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group my-2">
                <div class="list-group-item">
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            Checked checkbox
                        </label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary">Añadir Usuarios</button>
        </div>
    </div>
    <script>
        const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
        moduleCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                var moduleId = this.id.replace('_enabled', '');
                var status = this.checked;
                enableModule(moduleId, status);
            });
        });
    </script>
</body>

</html>