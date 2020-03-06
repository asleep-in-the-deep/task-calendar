<?php

class Task extends DatabaseModel {
    public function __construct($data) {
        $this->data = $data;
        parent::__construct();
    }

    public static function getFields() {
        return ["id" => "primary|integer|default|increment",
                "date" => "date",
                "title" => "varchar:255|not_null",
                "color" => "varchar:20|default:yellow",
                "hours" => "float|default:1",
                "status" => "boolean|default:0"];
    }

    public static function getTableName() {
        return "tasks";
    }
}
