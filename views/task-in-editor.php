<section id="task_<?= $this->task_id ?>" class="task <?= $this->classname ?>" data-hours="<?= $this->hours ?>">
    <span><?= $this->title ?></span>
    <div class="edit-task<?php if ($this->task_id == 0) { ?>-empty<?php } ?>">
    <div class="task-hours emoji"><?= $this->hours ?></div>
</section>
