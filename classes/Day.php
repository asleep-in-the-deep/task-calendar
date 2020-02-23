<?php

class Day extends DatabaseModel {
	public function __construct($data) {
		$this->data = $data;
		$this->tablename = "days";
	}

	public static function getTableName() {
		return "days";
	}

    public function isHoliday() {
        if ($this['status'] == 0) {
            return true;
        }
        return false;
    }
}
