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

global $db;

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}