<?php

class Task extends DatabaseModel {
    public function __construct($data) {
        $this->data = $data;
        $this->tablename = "tasks";
    }

    public static function getTableName() {
        return "tasks";
    }
}
