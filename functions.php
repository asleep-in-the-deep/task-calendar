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
    }
}

function getTasks($date) {
    $tasks = Task::whereDateEq($date);
    $view = new Views\Tasks($tasks);
    $view->render();
}

function isHoliday($date) {
	$days = Day::whereDateEq($date);

    if (count($days) > 0) {
        foreach ($days as $k => $day) {
            if ($day['status'] == 0) {
                return true;
            }
        }
    }
	return false;
}

function isFinishedDay($date) {
	$days = Day::whereDateEq($date);

	if (count($days) > 0)
	{
		foreach ($days as $k => $day) {
			if ($day['status'] == 1) {
                echo '<div class="finished"></div>';
            }
		}
	} else {
        echo '<div class="add-task"></div>';
    }
}

function getCalendar($month = '', $year = '') {
	$grid = new Views\DaysGrid($month, $year);
	$grid->render();
}