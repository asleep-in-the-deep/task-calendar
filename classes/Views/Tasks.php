<?php

namespace Views;

class Tasks
{
    protected $internal;
    private $classname;
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
            require "views/task.php";
        }
    }
}