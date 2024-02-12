<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.scss">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="http://www.myersdaily.org/joseph/javascript/md5.js"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
</head>

<body id="background">
    <div class="container">
        <div id="main">
            <form method="post">
                <div class="image">
                    <img id="logo" src="../img/logov2.png">
                </div>
                <h2 class="login_title">INICIAR SESIÓN</h2>
                <div class="align-items-center mb-4 d-flex justify-content-center">
                    <div class="login_icon">
                        <img src="../img/user-icon.png" alt="" class="icon">
                    </div>
                    <div class="form-floating ms-2">
                        <input name="username" class="form-control login_input" id="userInput"
                            placeholder="name@example.com">
                        <label for="userInput">Usuario</label>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="login_icon">
                        <img src="../img/lock-icon.png" alt="" class="icon">
                    </div>
                    <div class="form-floating ms-2">
                        <input name="password" type="password" class="form-control login_input" id="passInput"
                            placeholder="Password">
                        <label for="passInput">Contraseña</label>
                    </div>
                </div>
                <div>
                    <input class="bg-primary" type="submit" value="INGRESAR" id="submit">
                </div>
                <?php if (isset($errorLogin))
                    echo "<div class=\"alert alert-danger\" style=\"font-size: .8rem;\" role=\"alert\">" . $errorLogin . "</div>" ?>
                </form>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#forgottenPassModal">Olvidé mi
                        contraseña</button>
            </div>
        </div>

        <div class="modal fade" id="forgottenPassModal" tabindex="-1" aria-labelledby="forgottenPassModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgottenPassModalLabel">Reestablecer Contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Escribe tu correo electrónico:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>