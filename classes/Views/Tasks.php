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
			$this->hours = $task["hours"];
            require "views/task.php";
        }
    }

    public function renderEditor()
    {
        if (count($this->internal) > 0) {
            $this->classname = "gray";
            $this->title = "Задание";
            $this->task_id = 0;
            $this->hours = "⏱";
            require "views/task-in-editor.php";
            foreach ($this->internal as $k => $task) {
                $this->classname = ($task['status'] == 0) ? $task['color'] : "done";
                $this->title = $task["title"];
                $this->task_id = $task['id'];
				$this->hours = $task["hours"];
                require "views/task-in-editor.php";
            }
        } else {
            echo "Задачи не найдены.";
        }
    }
}