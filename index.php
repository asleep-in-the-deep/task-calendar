<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

require_once 'config.php';
require_once 'functions.php';

require_once 'views/helpers.php';
require_once 'views/template.php';
?>