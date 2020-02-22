<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

setlocale(LC_ALL, 'ru_RU.UTF-8');
ini_set('date.timezone', 'Europe/Moscow');

$dbHost = 'localhost';
$dbUsername = 'calendar';
$dbPassword = 'LbMLQxpBecvy2d1V';
$dbName = 'calendar';

$config = Config::getInstance();
$config["db_host"] = $dbHost;
$config["db_user"] = $dbUsername;
$config["db_pass"] = $dbPassword;
$config["db_name"] = $dbName;
