<div class="calendar-header">
    <h1><select class="month-select"><?= getAllMonths($dateMonth) ?></select></h1>
    <select class="year-select"><?=getYearList($dateYear) ?></select>
</div>
<div class="calendar">
    <span class="day-name">Пн</span>
    <span class="day-name">Вт</span>
    <span class="day-name">Ср</span>
    <span class="day-name">Чт</span>
    <span class="day-name">Пт</span>
    <span class="day-name">Сб</span>
    <span class="day-name">Вс</span>
<?php
$dayCount = 1;
for ($i=1; $i<=$dayBoxes; $i++) {
    if ($i >= $currentFirstWeekDay && $dayCount <= $totalDaysOfMonth) {
        $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
        $currentDay = date('j', strtotime($currentDate));
        $disabled = ($i % 7 == 0 || ($i % 7 - 6) == 0 || isHoliday($currentDate));
        require 'views/day.php';
        $dayCount++;
    } else {
        require 'views/day_disabled.php';
    }
}?>
</div>