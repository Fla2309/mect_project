<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.css">
	<link rel="stylesheet" href="../css/main.css">
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
                <label class="login_text">
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
                </div>
                <a href="#" style="font-family: ibm plex sans;">Olvidé mi contraseña</a>
            </div>
        </div>
    </form>
</body>

</html>