<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

require_once 'config.php';
require_once 'functions.php';

Database::getInstance();

echo json_encode(Task::all());

?>
