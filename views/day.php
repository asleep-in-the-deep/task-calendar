<div class="day <?= $this->disabled?' disabled':'' ?>" data-date="<?= $this->currentDate ?>">
	<?php if (!$this->disabled): ?>
        <div class="day-button">Изменить</div>
	<?php endif ?>
    <span class="day-number<?= isCurrentDay($this->currentDate)?' current':'' ?>">
		<?= $this->currentDay ?>
	</span>
	<div class="add-task"></div>
	<div class="task-group">
	    <?php
	    getTasks($this->currentDate);
	    if ($this->day['status'] == 1): ?>
		<div class="finished"></div>
	    <?php elseif(!$this->disabled): ?>
	    <?php endif ?>
	</div>
</div>
