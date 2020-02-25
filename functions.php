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
        case 'renameTask':
            renameTask($_POST['id'], $_POST['title']);
            break;
        case 'setStatusTask':
            setStatusTask($_POST['id'], $_POST['status']);
            break;
        case 'changeColorTask':
            changeColorTask($_POST['id'], $_POST['color']);
            break;
        case 'editCommentTask':
            editCommentTask($_POST['id'], $_POST['comment']);
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

function renameTask($id, $title) {
    $task = Task::get($id);
    if ($task !== null) {
        $task["title"] = $title;
        $task->save();
    }
}

function setStatusTask($id, $status) {
    if (status == 0 || $status == 1) {
        $task = Task::get($id);
        if ($task !== null) {
            $task["status"] = $status;
            $task->save();
        }
    }
}

function editCommentTask($id, $comment) {
    $task = Task::get($id);
    if ($task !== null) {
        $task["comment"] = $comment;
        $task->save();
    }
}

function changeColorTask($id, $color) {
    $task = Task::get($id);
    if ($task !== null) {
        $task["color"] = $color;
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