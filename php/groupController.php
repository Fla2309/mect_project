<?php

include_once('settingsModel.php');
$settings = new Settings($_GET['userId']);

if (isset($_GET['data'])) {
    switch ($_GET['data']) {
        case 'payments':
            break;
        default:
            http_response_code(404);
            break;
    }
}


?>