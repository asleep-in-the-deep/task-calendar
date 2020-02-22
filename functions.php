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
    $db = Database::getInstance()->direct();

    $result = $db->query('SELECT * FROM tasks WHERE date = "'.$date.'"');
    $eventNum = $result->num_rows;

    if($result->num_rows > 0) {
        if ($eventNum > 0) {
            while($task = $result->fetch_assoc()) {
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
    $db = Database::getInstance()->direct();
    $result = $db->query('SELECT * FROM days WHERE date = "'.$date.'"');

    if ($result->num_rows > 0) {
        while($day = $result->fetch_assoc()) {
            if ($day['status'] == 0) {
                return true;
            }
        }
    }
}

function isFinishedDay($date) {
    $db = Database::getInstance()->direct();
    $result = $db->query('SELECT * FROM days WHERE date = "'.$date.'"');

    if ($result->num_rows > 0) {
        while($day = $result->fetch_assoc()) {
            if ($day['status'] == 1) {
                echo '<div class="finished"></div>';
            }
        }
    } else {
        echo '<div class="add-task"></div>';
    }
}

function getCalendar($month = '', $year = '') {
	// TODO: validation $month and $year
    if ($month == '') {
        $month = date('m');
    }

    if ($year == '') {
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