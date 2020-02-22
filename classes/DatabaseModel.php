<?php

// TODO: сделать общий класс для ArrayAccess
// Config и DatabaseModel с одинаковой реализацией

class DatabaseModel implements JsonSerializable, ArrayAccess  {
	protected $data;
	protected $tablename;

	public function jsonSerialize() {
		return $this->data;
	}

	public static function getTableName() {
		return "";
	}

	public static function whereDateEq($date) {
		$result = Database::getInstance()->direct()->query('SELECT * FROM '.static::getTableName().' WHERE date = "'.$date.'"');

		$objects = [];
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($objects, new static($row));
			}
		}
		return $objects;
	}

	public static function all() {
		$result = Database::getInstance()->direct()->query('SELECT * FROM '.static::getTableName());

		$objects = [];
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($objects, new static($row));
			}
		}
		return $objects;
	}

	public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value) {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
}
