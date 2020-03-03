<?php

function UseEmojiHook() {
    $config = Config::getInstance();

    if (!isset($config["emoji"])) return false;
    if ($config["emoji"] == "native") return false;
    return true;
}

function getYearList($selected = '') {
    $years = '';
    $minYear = 2019;
    $maxYear = 2022;
    for ($i=$minYear; $i<=$maxYear; $i++) {
        $selectOption = ($i == $selected) ? 'selected' : '';
        $years .= '<option value="'.$i.'" '.$selectOption.' >'.$i.'</option>';
    }
    return $years;
}

function getAllMonths($selected = '') {
    $months = '';
    $monthArray = array(
        "1" => "Январь", "2" => "Февраль", "3" => "Март", "4" => "Апрель",
        "5" => "Май", "6" => "Июнь", "7" => "Июль", "8" => "Август",
        "9" => "Сентябрь", "10" => "Октябрь", "11" => "Ноябрь", "12" => "Декабрь",
    );
    for ($i=1; $i<=12; $i++) {
        $value = ($i < 10) ? '0'.$i : $i;
        $selectOption = ($value == $selected) ? 'selected' : '';
        $months .= '<option value="'.$value.'" '.$selectOption.'>'.$monthArray[$i].'</option>';
    }
    return $months;
}

function isCurrentDay($date) {
    $currentDay = date('j', strtotime($date));
    $currentMonth = date('n', strtotime($date));

    if ($currentDay == date('j') && $currentMonth == date('n')) {
        return true;
    }
    return false;
}
