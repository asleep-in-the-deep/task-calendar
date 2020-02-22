<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

require_once 'config.php';
require_once 'functions.php';

Database::getInstance();
$t = new Task();
$t->all();

?>
