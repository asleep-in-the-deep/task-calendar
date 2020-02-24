<?php

class DatabaseModel implements JsonSerializable, ArrayAccess {
    use Traits\Storage;
    protected $tablename;

    public function jsonSerialize() {
        return $this->data;
    }

    public static function getTableName() {
        return "";
    }

    protected static function fetch($result) {
        $objects = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($objects, new static($row));
            }
        }
        return $objects;
    }

    public static function whereDateEq($date) {
        $result = Database::getInstance()->direct()->query('SELECT * FROM '.static::getTableName().' WHERE date = "'.$date.'"');
        return static::fetch($result);
    }

    public static function all() {
        $result = Database::getInstance()->direct()->query('SELECT * FROM '.static::getTableName());
        return static::fetch($result);
    }
}
