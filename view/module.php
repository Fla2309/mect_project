<?php
include_once('../php/modules.php');
session_start();
$userModule = new UserModule();
?>
<html>

<head>
</head>

<body>
    <button type="button" class="btn btn-primary" onclick="reloadModules()"><img src="../img/left-arrow.png" width="20">
        Volver</button>
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
                    if(!$userModule->getAdminPermissions()){
                        echo '<li class="nav-item">
                        <a class="nav-link" href="#feedback" data-bs-toggle="tab">Feedback</a>
                    </li>';
                    }
                    ?>
                    
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane card-body active" id="trabajos">
                    <?php
                    $htmlTrabajos = $userModule->prepareHtmlTrabajos();
                    echo $htmlTrabajos !== "" ? $htmlTrabajos : "<h5>No hay trabajos para mostrar</h5>"
                        ?>
                </div>
                <div class="tab-pane card-body" id="tareas">
                    <?php
                    $htmltareas = $userModule->prepareHtmlTareas();
                    echo $htmltareas !== "" ? $htmltareas : "<h5>No hay tareas para mostrar</h5>"
                        ?>
                </div>
                <?php
                if(!$userModule->getAdminPermissions()){
                echo '
                <div class="tab-pane card-body" id="feedback">' . 
                    $htmlFeedback = $userModule->prepareHtmlFeedback();
                    echo $htmlFeedback !== "" ? $htmlFeedback : "<h5>No hay feedback para mostrar</h5>".
                '</div>';}
                ?>
            </div>
        </div>
    </div>
</body>

</html>