<?php
include_once('../php/modules.php');
session_start();
$userModule = new UserModule();
?>
<html>

<head>
</head>

<body>
    <?php
    if ($userModule->getAdminPermissions())
        echo '<script src="../js/moduleAdmin.js"></script>';
    ?>
    <table hidden="true">
        <tr>
            <td><input type="text" id="user" value="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
            <td><input type="text" id="userId" value="<?php echo $_SESSION['userId'] ?>" class="user_properties"></td>
            <td><input type="text" id="moduleId" value="<?php echo $_GET['module'] ?>" class="module_properties"></td>
        </tr>
    </table>
    <button type="button" class="btn btn-primary" onclick="reloadModules()"><img src="../img/left-arrow.png" width="20">
        Volver
    </button>
    <div class="px-2 py-2 mx-2 my-2">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-pills card-header-tabs mb-1">
                    <li class="nav-item">
                        <a class="nav-link active" href="#trabajos" data-bs-toggle="tab">Trabajos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tareas" data-bs-toggle="tab">Tareas</a>
                    </li>
                    <?php
                    if (!$userModule->getAdminPermissions()) {
                        echo '<li class="nav-item">
                        <a class="nav-link" href="#feedback" data-bs-toggle="tab">Feedback</a>
                    </li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#informacion" data-bs-toggle="tab">Información</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane card-body active" id="trabajos">
                    <?php
                    if ($userModule->getAdminPermissions())
                        echo '<div class="d-flex justify-content-start mb-3"><button type="button" class="btn btn-primary" onclick="addActivity(2)"><img src="../img/plus.png" width="20"> Añadir</button></div>';
                    $htmlTrabajos = $userModule->prepareHtmlTrabajos();
                    echo $htmlTrabajos !== "" ? $htmlTrabajos : "<h5>No hay trabajos para mostrar</h5>"
                        ?>
                </div>
                <div class="tab-pane card-body" id="tareas">
                    <?php
                    if ($userModule->getAdminPermissions())
                        echo '<div class="d-flex justify-content-start mb-3"><button type="button" class="btn btn-primary" onclick="addActivity(1)"><img src="../img/plus.png" width="20"> Añadir</button></div>';
                    $htmltareas = $userModule->prepareHtmlTareas();
                    echo $htmltareas !== "" ? $htmltareas : "<h5>No hay tareas para mostrar</h5>"
                        ?>
                </div>
                <?php
                if (!$userModule->getAdminPermissions()) {
                    echo '
                <div class="tab-pane card-body" id="feedback">' .
                        $htmlFeedback = $userModule->prepareHtmlFeedback();
                    echo $htmlFeedback !== "" ? $htmlFeedback : "<h5>No hay feedback para mostrar</h5>" .
                        '</div>';
                }
                ?>
                <div class="tab-pane card-body" id="informacion">
                    <?php
                    // $htmltareas = $userModule->prepareHtmlInfo();
                    // echo $htmlinfo !== "" ? $htmlinfo : "<h5>No hay información para mostrar</h5>"
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($userModule->getAdminPermissions()) {
        ?>
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editModule">
                        <div class="input-group mb-2" hidden>
                            <span class="input-group-text bg-primary text-white">ID</span>
                            <input class="form-control" placeholder="Nombre" id="actId">
                        </div>
                        <div class="input-group mb-2" hidden>
                            <span class="input-group-text bg-primary text-white">Tipo de actividad</span>
                            <input class="form-control" placeholder="Nombre" id="actType">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white">Nombre</span>
                            <input class="form-control" placeholder="Nombre" id="actName">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white">Módulo</span>
                            <select class="form-select" aria-label="Select module" id="modulesDropdown">
                                <?php
                                echo $userModule->getModuleHtmlDropdownTags();
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white">Plantilla</span>
                            <input class="form-control" placeholder="Plantilla" id="templateName">
                            <a href="" download="" class="template"><img src="img/template.png" class="dashboard_icon m-2"
                                    title="Descargar plantilla"></a>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white">Comentarios</span>
                            <textarea class="form-control" placeholder="Comentarios" id="comments"></textarea>
                        </div>
                        <p id="errorAct" class="text-danger" hidden></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="saveChanges()">Guardar
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
                        Información actualizada con éxito
                    </div>
                    <div class="modal-footer">
                        <p id="modal-footer_text">Serás redirigido al inicio en 3 segundos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="spinner" tabindex="-1" aria-labelledby="spinnerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mt-3 visually-hidden" id="loadingSpinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</body>

</html>