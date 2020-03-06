<?php

spl_autoload_register(function ($class) {
    include 'classes/' . str_replace('\\', '/', $class) . '.php';
});

if (!file_exists('config.php')) {
    if (file_exists('config.php.example')) {
        copy("config.php.example", "config.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = file_get_contents("settings.json");
    $new_config = [];
    if ($content) {
        $new_config = json_decode($content, true);
        if (!$new_config) {
            $new_config = [];
        }
    }
    $replaced = array_replace($new_config, ['emoji' => $_POST['emoji']]);
    file_put_contents("settings.json", json_encode($replaced));
}

require_once 'config.php';
require_once 'views/template_settings.php';
?>