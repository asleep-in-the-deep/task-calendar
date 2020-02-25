<?php

spl_autoload_register(function ($class) {
    include 'classes/' . str_replace('\\', '/', $class) . '.php';
});

require_once 'config.php';
require_once 'views/helpers.php';

if (isset($_POST['function']) && !empty($_POST['function'])) {
    switch($_POST['function']) {
        case 'getCalendar':
            getCalendar($_POST['month'], $_POST['year']);
            break;
        case 'getEvents':
            getTasks($_POST['date']);
            break;
        case 'moveTask':
            moveTask($_POST['id'], $_POST['date']);
            break;
    }
}

function moveTask($id, $date) {
    $task = Task::get($id);
    if ($task !== null) {
        $task["date"] = $date;
        $task->save();
    }
}

function getTasks($date) {
    $tasks = Task::whereDateEq($date);
    $view = new Views\Tasks($tasks);
    $view->render();
}

function getCalendar($month = '', $year = '') {
	$grid = new Views\DaysGrid($month, $year);
	$grid->render();
}