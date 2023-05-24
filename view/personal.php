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
<body onload="getPersonalModuleDocuments()">
<?php include_once('navbar.php') ?>
    <h1 class="pt-5 ms-5">Módulo Personal</h1>
    <hr class="divider px-5">
    <h5 class="mx-5 ps-2 my-3">
        En este sitio, deben ir cargados los documentos listados a continuación
    </h5>
    <div class="col-sm mx-5 my-5 pb-5">
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
                        <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar">
                        <img src="../img/download.png" title="Descargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar">
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
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar"></span>
                    <div class="col-3">
                        <input type="text" id="userRegistration" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Identificación (parte frontal)
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar"></span>
                    </span>
                    <div class="col-3">
                        <input type="text" id="userIdFront" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                </div>
            </div>
            <div class="d-flex mx-2 my-3">
                <div class="input-group me-3">
                    <span class="input-group-text bg-primary text-white">Identificación (parte trasera)
                    <img src="../img/upload.png" title="Cargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar">
                    <img src="../img/download.png" title="Descargar documento" class="dashboard_icon ms-2 color_invert" alt="Cargar"></span>
                    </span>
                    <div class="col-3">
                        <input type="text" id="userIdBack" readonly class="form-control-plaintext ms-3"
                        value="Patatas Friuas">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include_once('footer.html') ?>
</body>
</html>