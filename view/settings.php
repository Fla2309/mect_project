<?php

    include_once('../php/settingsModel.php');
    $settings = new Settings($_GET['userId']);
    $row = $settings->retrieveSettings();
    if($row == 406)
        header('Location:./unavailable.php');
?>

<html lang="en">

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
    <?php if ($row['nivel_usuario'] > 1)
        echo '<script src="../js/admin.js"></script>'; ?>

    <title>Configuración de cuenta</title>
</head>

<body>
    <?php include_once('navbar.php') ?>
    <h1 class="pt-5 ms-5">Configuración de la cuenta</h1>
    <hr class="divider px-5">
    <div class="col-sm mx-5 my-5 pb-5">
        <form action="post" id="settingsForm">
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3" hidden>
                    <span class="input-group-text bg-primary text-white">ID</span>
                    <input type="text" id="userId" aria-label="Id" value="<?php echo $row['id']; ?>"
                        class="form-control" disabled>
                </div>
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Nombres y apellidos</span>
                    <input type="text" id="userName" aria-label="First name" value="<?php echo $row['nombre']; ?>"
                        class="form-control" disabled>
                    <input type="text" id="userLastname" aria-label="Last name" value="<?php echo $row['apellidos']; ?>"
                        class="form-control" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white" id="nickname">Nombre/Alias preferido</span>
                    <input type="text" id="userAlias" class="form-control"
                        value="<?php echo $row['nombre_preferido']; ?>">
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Grupo de PL/AM</span>
                    <input type="text" id="userPl" class="form-control" value="<?php echo $row['id_pl']; ?>" disabled>
                </div>
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Grupo de MECT</span>
                    <input type="text" id="userGroup" class="form-control" value="<?php echo $row['id_grupo']; ?>"
                        disabled>
                </div>
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Nombre grupo</span>
                    <input type="text" id="userGroupName" class="form-control"
                        value="<?php echo $row['nombre_grupo']; ?>" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">Fecha ingreso MECT</span>
                    <input type="text" id="userDate" class="form-control" value="<?php echo $row['fecha_ingreso']; ?>"
                        disabled>
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Correo</span>
                    <input type="text" id="userMail" class="form-control" value="<?php echo $row['correo']; ?>">
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">Teléfono</span>
                    <input type="text" id="userPhone" class="form-control" value="<?php echo $row['telefono']; ?>">
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Usuario</span>
                    <input type="text" id="userLogin" class="form-control" value="<?php echo $row['login_user']; ?>">
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">Contraseña</span>
                    <input type="password" class="form-control" value="password" disabled>
                    <button class="btn btn-outline-primary" type="button" id="changePass" data-bs-toggle="modal"
                        data-bs-target="#passModal">Cambiar contraseña</button>
                </div>
            </div>
            <div class="mx-2 my-3 col-4">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">Foto de perfil</span>
                    <input type="text" id="profilePic" class="form-control text-truncate" value="<?php echo $_SESSION['foto_perfil']!=='none' ? explode('/', $_SESSION['foto_perfil'])[3] : 'Ninguna imagen seleccionada'; ?>" disabled>
                    <button class="btn btn-outline-primary" type="button" id="changeProfilePic" data-bs-toggle="modal"
                        data-bs-target="#profilePicModal">Cambiar foto</button>
                </div>
                <img src="../<?php echo $_SESSION['foto_perfil']!=='none' ? $_SESSION['foto_perfil'] : '../img/user_pic.png'; ?>" alt="Foto de perfil" class="mt-2 settings_profile_pic">
            </div>
            <hr class="divider px-5">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary me-2" onclick="discardSettings()">Descartar
                    cambios</button>
                <button type="button" class="btn btn-outline-primary" onclick="saveSettings(0)">Guardar</button>
            </div>
            <div class="d-flex justify-content-center mt-3 visually-hidden" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
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
    <div class="modal fade" id="profilePicModal" tabindex="-1" aria-labelledby="passModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar foto de perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="profilePicChange">
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nombre</span>
                        <input type="text" id="profilePicInput" class="form-control" 
                                placeholder="Directorio de la imagen">
                        <input type="file" id="openProfilePic" class="form-control visually-hidden" 
                                accept="image/*" onchange="showImage(this)">
                        <label class="btn btn-outline-primary" for="openProfilePic">Examinar...</label>
                    </div>
                    <div id="imageViewer" class="text-center visually-hidden">
                        <img id="imageUploaded" src="" alt="">
                    </div>
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