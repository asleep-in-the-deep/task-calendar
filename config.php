<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

setlocale(LC_ALL, 'ru_RU.UTF-8');
ini_set('date.timezone', 'Europe/Moscow');

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'calendar';

$config = Config::getInstance();
$config["db_driver"] = "mysql";
$config["db_host"] = $dbHost;
$config["db_user"] = $dbUsername;
$config["db_pass"] = $dbPassword;
$config["db_name"] = $dbName;

$config["db_driver"] = "sqlite";
$config["db_file"] = "calendar3.db";

$config["emoji"] = "native"; // android, native
