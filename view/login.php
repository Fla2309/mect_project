<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body id="background">
    <form method="post">
        <div class="container">
            <div id="main">
                <div class="image">
                    <img id="logo" src="../img/logov2.png">
                </div>
                <?php if (isset($errorLogin))
                    echo "<div class=\"alert alert-danger\" style=\"font-size: .8rem;\" role=\"alert\">" . $errorLogin . "</div>" ?>
                    <!--<label class="login_text">
                                    Usuario
                                </label>
                                <div>
                                    <img src="../img/user-icon.png" alt="" class="icon">
                                    <input name="username" class="login_input" type="text" placeholder="ejemplo@correo.com">
                                </div>

                                <label class="login_text">
                                    Contraseña
                                </label>
                                <div>
                                    <img src="../img/lock-icon.png" alt="" class="icon">
                                    <input name="password" class="login_input" type="password" placeholder="Contraseña123">
                                </div>
                                <div>
                                    <input class="bg-primary" type="submit" value="INGRESAR" id="submit">
                                </div>-->

                    <h2 class="login_title">INICIAR SESIÓN</h2>
                    <div class="align-items-center mb-4 d-flex">
                        <div class="login_icon">
                            <img src="../img/user-icon.png" alt="" class="icon">
                        </div>
                        <div class="form-floating flex-fill ml-1">
                            <input name="username" class="form-control login_input" id="userInput"
                                placeholder="name@example.com">
                            <label for="userInput">Usuario</label>
                        </div>
                    </div>
                    <div class="align-items-center d-flex">
                        <div class="login_icon">
                            <img src="../img/lock-icon.png" alt="" class="icon">
                        </div>
                        <div class="form-floating flex-fill ml-1">
                            <input name="password" type="password" class="form-control login_input" id="passInput"
                                placeholder="Password">
                            <label for="passInput">Contraseña</label>
                        </div>
                    </div>
                    <div>
                        <input class="bg-primary" type="submit" value="INGRESAR" id="submit">
                    </div>
                    <a href="#">Olvidé mi contraseña</a>
                </div>
            </div>
        </form>
    </body>

    </html>