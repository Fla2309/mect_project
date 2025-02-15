<html lang="en">

<head>
</head>

<body>
    <?php
    $notificationsDetails = "";
    if ($_SESSION['global_notifications'] != []) {
        foreach ($_SESSION['global_notifications'] as $notification) {
            echo "<div class=\"alert alert-warning alert-dismissible my-0 fade show\" role=\"alert\">
                <strong>{$notification['titulo']}:</strong> {$notification['texto']}
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>";
        }
    }

    if ($_SESSION['notifications'] != []) {
        $newNotifications = count(array_filter($_SESSION['notifications'], fn($fila) => $fila['leido'] == 0));
        $notificationsBadge = $newNotifications > 0 ?
            "<span id=\"numberNotifications\" class=\"position-absolute top-30 start-70 translate-middle badge rounded-pill bg-danger\">" . $newNotifications . "<span class=\"visually-hidden\">unread messages</span></span>" :
            "";
        $notificationImage = "";
        $count = 0;
        foreach ($_SESSION['notifications'] as $notification) {
            $newNotification = "";
            $count++;
            if (stripos($notification['titulo'], 'Trabajo') || stripos($notification['titulo'], 'Tarea') || stripos($notification['titulo'], 'Módulo')) {
                $notificationImage = "<div class=\"my-auto me-3\"><img src=\"../img/book.png\" style=\"width:2em\"></div>";
            } else if (stripos($notification['titulo'], 'Coaching')) {
                $notificationImage = "<div class=\"my-auto me-3\"><img src=\"../img/coaching.png\" style=\"width:2em\"></div>";
            } else if (stripos($notification['titulo'], 'Presentación')) {
                $notificationImage = "<div class=\"my-auto me-3\"><img src=\"../img/presentation.png\" style=\"width:2em\"></div>";
            } else if (stripos($notification['titulo'], 'Examen')) {
                $notificationImage = "<div class=\"my-auto me-3\"><img src=\"../img/test.png\" style=\"width:2em\"></div>";
            } else {
                $notificationImage = "<div class=\"my-auto me-3\"><img src=\"./img/notif.png\" style=\"filter: invert(1); width:2em\"></div>";
            }
            if ($count > 1) {
                $notificationsDetails .= "<hr class=\"m-auto mx-3 divider border border-1\">";
            }
            if ($notification['leido'] == 0) {
                $newNotification = " new-notification";
            }
            $notificationsDetails .= "<a href=\"#\" class=\"dropdown-item notification-item{$newNotification}\"><div class=\"d-flex\">{$notificationImage}<div class=\"text-truncate\" title=\"{$notification['texto']}\"><h6>{$notification['titulo']}</h6>{$notification['texto']}</div></div></a>";
        }
    } else {
        $notificationsBadge = "";
    }
    ?>
    <nav class="navbar navbar-expand-md" id="nav_bar">
        <div class="container-fluid">
            <a href="/index.php" class="navbar-brand"><img src="../img/mect_logo.png" id="nav_logo"></a>
            <form class="d-flex" style="display: inline-block; margin-left: auto; margin-right: auto; text-align: left;"
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
            <script>
                const notificationIcon = document.querySelector('#notificationsButton');
                document.addEventListener('DOMContentLoaded', () => {
                    const notifications = document.querySelectorAll('a.dropdown-item.new-notification');

                    notifications.forEach(item => {
                        item.addEventListener('mouseover', () => {
                            item.classList.remove('new-notification');
                        });
                    });
                });
                document.addEventListener('DOMContentLoaded', () => {
                    const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');

                    dropdowns.forEach(dropdownToggle => {
                        dropdownToggle.addEventListener('show.bs.dropdown', () => {
                            const span = dropdownToggle.querySelector('#numberNotifications');
                            if (span) {
                                span.remove();
                                readNotifications();
                            }
                        });
                    });
                });
            </script>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-options"
                aria-controls="navbar-options" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-options">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../view/help.php"><img src="../img/help.png" title="Ayuda" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="../img/calendar.png" title="Calendario" alt=""
                                class="nav_bar_icon nav-item"></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" id="notificationsButton" title="Notificaciones"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../img/notif.png" title="Notificaciones" alt="" class="nav_bar_icon nav-item">
                            <?php echo $notificationsBadge; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsButton"
                            style="max-width: 25em">
                            <?php echo $notificationsDetails != "" ? $notificationsDetails : "No hay notificaciones"; ?>
                        </div>
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