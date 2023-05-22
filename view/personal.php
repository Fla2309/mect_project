<?php



?>

<html lang="en">
<head>
<head>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.scss">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="http://www.myersdaily.org/joseph/javascript/md5.js"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/settings.js"></script>

    <title>Módulo Personal</title>
</head>
</head>
<body>
<?php include_once('navbar.php') ?>
    <h1 class="pt-5 ms-5">Módulo Personal</h1>
    <hr class="divider px-5">
    <h5 class="mx-5 ps-2 my-3">
        En este sitio, deben ir cargados los documentos listados a continuación
    </h5>
    <div class="col-sm mx-5 my-5 pb-5">
        <form action="post" id="settingsForm">
            <div class="mx-2 my-3">
                <div class="input-group me-3" hidden>
                    <span class="input-group-text bg-primary text-white">ID</span>
                    <input type="text" id="userId" aria-label="Id" value="<?php echo $row['id']; ?>"
                        class="form-control" disabled>
                </div>
                <div class="input-group">
                    <label class="input-group-text bg-primary text-white" id="nickname">Currículum</label>
                    <div class="col-1">
                        <input type="text" id="userResume" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon me-2" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon" alt="Cargar">
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Formato de inscripción</span>
                    <div class="col-1">
                        <input type="text" id="userRegistration" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon me-2" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon" alt="Cargar">
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Identificación (parte frontal)</span>
                    <div class="col-1">
                        <input type="text" id="userIdFront" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon me-2" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon" alt="Cargar">
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Identificación (parte trasera)</span>
                    <div class="col-1">
                        <input type="text" id="userIdBack" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon me-2" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon" alt="Cargar">
                </div>
            </div>
        </form>
    </div>

    <!--Modals-->

    <div class="modal fade" id="passModal" tabindex="-1" aria-labelledby="passModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="passwordChange">
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Contraseña
                            actual</span>
                        <input type="password" id="currentPass" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nueva
                            contraseña</span>
                        <input type="password" id="newPass" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Confirmar
                            contraseña</span>
                        <input type="password" id="confirmNewPass" class="form-control" placeholder="Contraseña">
                    </div>
                    <p id="errorPassword" class="text-danger" hidden></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveSettings(1)">Guardar
                        cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="discardChangesModal" tabindex="-2" aria-labelledby="discardChangesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Descartar Cambios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Seguro que quieres salir sin guardar cambios?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="/index.php"><button type="button" class="btn btn-primary">Aceptar</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="usernameErrorModal" tabindex="-1" aria-labelledby="usernameErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usernameErrorModalLabel">Error al guardar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="usernameErrorModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
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
    <?php include_once('footer.html') ?>
</body>
</html>