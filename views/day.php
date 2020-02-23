<div class="day<?= $this->disabled?' disabled':'' ?>">
	<?php if (!$this->disabled): ?>
        <div class="day-button">Изменить</div>
	<?php endif ?>
    <span class="day-number<?= isCurrentDay($this->currentDate)?' current':'' ?>">
		<?= $this->currentDay ?>
	</span>
    <?php
    getTasks($this->currentDate);
    if ($this->day['status'] == 1): ?>
        <div class="finished"></div>
    <?php elseif(!$this->disabled): ?>
        <div class="add-task"></div>
    <?php endif ?>
</div>
