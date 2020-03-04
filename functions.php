<?php

use Views\Tasks;

spl_autoload_register(function ($class) {
    include 'classes/' . str_replace('\\', '/', $class) . '.php';
});

require_once 'config.php';
require_once 'views/helpers.php';

if (isset($_REQUEST['function']) && !empty($_REQUEST['function'])) {
    switch($_REQUEST['function']) {
        case 'getCalendar':
            getCalendar($_POST['month'], $_POST['year']);
            break;
        case 'getEvents':
            getTasks($_POST['date']);
            break;
        case 'loadTasks':
            loadTasks($_POST['date']);
            break;
        case 'deleteTask':
            deleteTask($_POST['id']);
            break;
        case 'createTask':
            createTask($_POST['date'], $_POST['title'], $_POST['hours'], $_POST['color']);
            break;
        case 'changeTask':
            changeTask($_POST['id'], $_POST['title'], $_POST['hours'], $_POST['color'], $_POST['status']);
            break;
        case 'moveTask':
            moveTask($_REQUEST['id'], $_REQUEST['date']);
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
        case 'setStatusDay':
            setStatusDay($_POST['date'], $_POST['status']);
            break;
    }
}

function deleteTask($id) {
    $task = Task::get($id);
    if ($task !== null) {
        $task->delete();
    }
}

function changeTask($id, $title, $hours, $color, $status) {
    $task = Task::get($id);
    if ($task !== null) {
        $task["title"] = $title;
        $task["hours"] = $hours;
        $task["color"] = $color;
        $task["status"] = $status;
        $task->save();
    }
    echo json_encode($task);
}

function createTask($date, $title, $hours, $color) {
    $task = new Task(["date" => $date,
        "title" => $title,
        "hours" => $hours,
        "color" => $color]);
    $task->create();
    echo json_encode($task);
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
    if ($status == 0 || $status == 1) {
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

function setStatusDay($date, $status) {
    if ($status == 0 || $status == 1 || $status==-1) {
        $day = Day::get($date);
        if ($day !== null) {
            $day["status"] = $status;
            if ($status == -1) {
                $day->delete();
            } else {
                $day->save();
            }
        } else if ($status != -1) {
            $day = new Day(["date" => $date, "status" => $status]);
            $day->create();
        }
    }
}

function getTasks($date) {
    $tasks = Task::whereDateEq($date);
    $view = new Views\Tasks($tasks);
    $view->render();
}

function loadTasks($date) {
    $tasks = Task::whereDateEq($date);
    $view = new Views\Tasks($tasks);
    $view->renderEditor();
}

function getCalendar($month = '', $year = '') {
	$grid = new Views\DaysGrid($month, $year);
	$grid->render();
}