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
        <script src="../js/file.js"></script>

        <title>Módulo Personal</title>
    </head>
</head>

<body onload="getPersonalModuleDocuments()">
    <?php include_once('navbar.php') ?>
    <h1 class="pt-5 ms-5">Módulo Personal</h1>
    <hr class="divider px-5">
    <h3 class="mx-5">Documentos de Usuario</h3>
    <h5 class="mx-5 ps-2 my-3">
        En este apartado, deben ir cargados los documentos listados a continuación
    </h5>
    <div class="col-sm mx-5 mt-5 mb-2 pb-2">
        <form action="get" id="personalModuleForm">
            <div class="mx-2 my-3">
                <div class="input-group me-3" hidden>
                    <span class="input-group-text bg-primary text-white">ID</span>
                    <input type="text" id="userId" aria-label="Id" value="<?php echo $_GET['userId']; ?>"
                        class="form-control" disabled>
                </div>
                <div class="input-group d-flex">
                    <span class="input-group-text bg-primary text-white">
                        Currículum
                        <label for="upload-resume" onclick="selectFile(this)">
                            <img src="../img/upload.png" title="Cargar documento"
                                class="dashboard_icon ms-2 color_invert" alt="Cargar">
                        </label>
                        <input style="display: none;" id="upload-resume" name="foto" type="file"
                                onchange="uploadDocument(this)">
                        <a href="" download="" id="download-resume"><img src="../img/download.png"
                                title="Descargar documento" class="dashboard_icon ms-2 color_invert"
                                alt="Descargar"></a>
                    </span>
                    <div class="col-3">
                        <input type="text" id="userResume" readonly class="form-control-plaintext ms-3">
                    </div>
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">
                        Formato de inscripción
                        <label for="upload-registration" onclick="selectFile(this)">
                            <img src="../img/upload.png" title="Cargar documento"
                                class="dashboard_icon ms-2 color_invert" alt="Cargar">
                        </label>
                        <input style="display: none;" id="upload-registration" name="foto" type="file"
                                onchange="uploadDocument(this)">
                        <a href="" download="" id="download-registration"><img src="../img/download.png"
                                title="Descargar documento" class="dashboard_icon ms-2 color_invert"
                                alt="Descargar"></a>
                    </span>
                    <div class="col-3">
                        <input type="text" id="userRegistration" readonly class="form-control-plaintext ms-3">
                    </div>
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">
                        Identificación (parte frontal)
                        <label for="upload-id-front" onclick="selectFile(this)">
                            <img src="../img/upload.png" title="Cargar documento"
                                class="dashboard_icon ms-2 color_invert" alt="Cargar">
                        </label>
                        <input style="display: none;" id="upload-id-front" name="foto" type="file"
                                onchange="uploadDocument(this)">
                        <a href="" download="" id="download-id-front"><img src="../img/download.png"
                                title="Descargar documento" class="dashboard_icon ms-2 color_invert"
                                alt="Descargar"></a>
                    </span>
                    <div class="col-3">
                        <input type="text" id="userIdFront" readonly class="form-control-plaintext ms-3">
                    </div>
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Identificación (parte trasera)
                        <label for="upload-id-back" onclick="selectFile(this)">
                            <img src="../img/upload.png" title="Cargar documento"
                                class="dashboard_icon ms-2 color_invert" alt="Cargar">
                        </label>
                        <input style="display: none;" id="upload-id-back" name="foto" type="file"
                                onchange="uploadDocument(this)">
                        <a href="" download="" id="download-id-back"><img src="../img/download.png"
                                title="Descargar documento" class="dashboard_icon ms-2 color_invert"
                                alt="Descargar"></a>
                    </span>
                    <div class="col-3">
                        <input type="text" id="userIdBack" readonly class="form-control-plaintext ms-3">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <hr class="divider">
    <h3 class="mx-5">Información del Proceso Transformacional</h3>
    <h5 class="mx-5 ps-2 my-3">
        En este apartado, se muestra la información de la jornada transformacional del usuario
    </h5>
    <div class="col-sm mx-5 mt-5 mb-2 pb-2">
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Básico/Bloque 1
            </span>
            <input type="text" id="userProcessB1" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Avanzado/Bloque 2
            </span>
            <input type="text" id="userProcessB2" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Contrato</span>
            <input type="text" id="userProcessContract" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Estiramiento en Avanzado/Bloque 2</span>
            <input type="text" id="userProcessTrainingB2" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Canción de Cuna de Avanzado/Bloque 2
            </span>
            <input type="text" id="userProcessB2Song" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Programa de Liderazgo/Acciona y
                Materializa</span>
            <input type="text" id="userProcessPL" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Fuente</span>
            <input type="text" id="userProcessSource" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Estiramiento en PL/AM
            </span>
            <input type="text" id="userProcessTrainingPL" class="form-control" value="" disabled>
        </div>
        <div class="input-group col-md-6 mx-2 my-3">
            <span class="input-group-text bg-primary text-white">Canción de Cuna de Tercer Fin
            </span>
            <input type="text" id="userProcessPLSong" class="form-control" value="" disabled>
        </div>
    </div>
    <?php include_once('footer.html') ?>
</body>

</html>