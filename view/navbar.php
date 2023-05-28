<html lang="en">

<head>
</head>

<body>
    <nav class="navbar navbar-expand-lg" id="nav_bar">
        <div class="container-fluid">
            <a href="/index.php" class="navbar-brand"><img src="../img/mect_logo.png" id="nav_logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex"
                    style="display: inline-block; margin-left: auto; margin-right: auto; text-align: left;"
                    role="search" id="search">
                    <input class="form-control me-2" type="search" placeholder="Buscar en el sitio..." id="searchBox"
                        aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit" style="color: #ffffff;">Buscar</button>
                </form>
                <script>
                    const f = document.getElementById('search');
                    const q = document.getElementById('searchBox');
                    const google = 'https://www.google.com/search?q=site%3A+';
                    const site = 'mect.com.mx';

                    function submitted(event) {
                        event.preventDefault();
                        const url = google + site + '+' + q.value;
                        const win = window.open(url, '_blank');
                        win.focus();
                    }

                    f.addEventListener('submit', submitted);
                </script>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="position: absolute; right: 1%;">
                    <li class="nav-item">
                        <a class="nav-link" href="../view/help.php"><img src="../img/help.png" title="Ayuda" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="../img/calendar.png" title="Calendario" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><img src="../img/notif.png" title="Notificaciones" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="userDropdown" title="Menú de usuario" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../img/user.png" alt="" class="nav_bar_icon nav-item">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php echo isset($_SESSION['userId']) ? '<a href="../view/personal.php?userId=' . $_SESSION['userId'] . '" class="dropdown-item">Módulo personal</a>' : ''; ?>
                            <?php echo isset($_SESSION['userId']) ? '<a href="../view/settings.php?userId=' . $_SESSION['userId'] . '" class="dropdown-item">Configuración</a>' : ''; ?>
                            <hr class="divider">
                            <a href="../php/logout.php" class="dropdown-item">Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>