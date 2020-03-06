<?php

class Day extends DatabaseModel {
    public function __construct($data) {
        $this->data = $data;
        parent::__construct();
    }

    public static function getTableName() {
        return "days";
    }

    public static function getFields() {
        return ["date" => "primary|date|not_null",
                "status" => "boolean|not_null"];
    }

    public function isHoliday() {
        if ($this['status'] == 0) {
            return true;
        }
        return false;
    }
}
