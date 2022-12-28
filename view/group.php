<?php



?>

<html lang="en">
<head>
</head>
<body>
    <button type="button" class="btn btn-primary" onclick="reloadGroups()"><img src="../img/left-arrow.png" width="20">  Volver</button>
    <div class="px-2 py-2 mx-2 my-2">
        <div class="card text-center">
            <div class="card-header">
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
                <div class="tab-pane card-body active" id="trabajos">
                    <?php
                    echo $userModule->prepareHtmlTrabajos($userModule->getTrabajosPerUser())
                    ?>
                </div>
                <div class="tab-pane card-body" id="tareas">
                    <?php
                    echo $userModule->prepareHtmlTareas($userModule->getTareasPerUser());
                    ?>
                </div>
                <div class="tab-pane card-body" id="informacion">
                    <h5 class="card-title">Info</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>