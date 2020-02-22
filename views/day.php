<div class="day<?= $disabled?' disabled':'' ?>"><?php if (!$disabled) { ?>
	<div class="day-button">Изменить</div><?php } ?>
	<span class="day-number<?= isCurrentDay($currentDate)?' current':'' ?>"><?= $currentDay ?></span>
    <?php
    getTasks($currentDate);
    isFinishedDay($currentDate);
    ?>
</div>
