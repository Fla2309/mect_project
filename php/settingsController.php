<?php

include_once('settingsModel.php');

(new Settings($_GET['userId']))->saveSettings();

?>