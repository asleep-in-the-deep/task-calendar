<?php

namespace Views;

class Tasks
{
    protected $internal;
    private $classname;
    private $task_id;
    private $title;
    public function __construct($tasks)
    {
        $this->internal = $tasks;
    }

    public function render()
    {
        foreach ($this->internal as $k => $task) {
            $this->classname = ($task['status'] == 0) ? $task['color']:"done";
            $this->title = $task["title"];
            $this->task_id = $task['id'];
            require "views/task.php";
        }
    }
}