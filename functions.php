<?php
require_once 'config.php';

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
	/* Зачем? */
    $eventNum = count($tasks);

    if(count($tasks) > 0) {
        if ($eventNum > 0) {
	/* */
            foreach ($tasks as $k => $task) {
                if ($task['status'] == 0) {
                    echo '<section class="task '.$task['color'].'">'.$task['title'].'</section>';
                } else {
                    echo '<section class="task done">'.$task['title'].'</section>';
                }
            }
        }
    }
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
	//TODO: validation of $month and $year
    if ($month != '') {
        $dateMonth = $month;
    } else {
        $dateMonth = date('m');
    }

    if ($year != '') {
        $dateYear = $year;
    } else {
        $dateYear = date('Y');
    }

    $firstMonthDay = '01-'.$dateMonth.'-'.$dateYear;

    $currentFirstWeekDay = date('N', strtotime($firstMonthDay));

    $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN, $dateMonth, $dateYear);

    if ($currentFirstWeekDay == 1) {
        $numberOfWeeks = $totalDaysOfMonth / 7;
    } else {
        $numberOfWeeks = ($totalDaysOfMonth + $currentFirstWeekDay) / 7;
    }

    if ($numberOfWeeks > 5 && $numberOfWeeks < 5.2) {
        $dayBoxes = round($numberOfWeeks) * 7;
    } else {
        $dayBoxes = ceil($numberOfWeeks) * 7;
    }

    require("views/calendar.php");
}