<?php

class Task extends DatabaseModel {
    public function __construct($data) {
        $this->data = $data;
        parent::__construct();
    }

    public static function getFields() {
        return ["id" => "primary|integer|default|increment",
                "date" => "date",
                "title" => "varchar:255",
                "color" => "varchar:20|default",
                "comment" => "text",
                "status" => "boolean|default"];
    }

    public static function getTableName() {
        return "tasks";
    }
}
