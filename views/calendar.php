<div class="calendar-header">
    <h1><select class="month-select"><?= getAllMonths($this->dateMonth) ?></select></h1>
    <select class="year-select"><?= getYearList($this->dateYear) ?></select>
    <div class="color-desc"></div>
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
$this->makeGrid();
?>
</div>
