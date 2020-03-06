<?php
spl_autoload_register(function ($class) {
    include 'classes/' . str_replace('\\', '/', $class) . '.php';
});

CheckFileAndFix("config.php");
CheckFileAndFix("calendar.db");
CheckFileAndFix("settings.json");

require_once 'config.php';
require_once 'functions.php';

require_once 'views/helpers.php';
require_once 'views/template.php';

function CheckFileAndFix($filename) {
    if (!file_exists($filename)) {
        if (file_exists("$filename.example")) {
            copy("$filename.example", $filename);
        }
    }
}

?>