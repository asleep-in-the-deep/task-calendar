<?php

class DatabaseModel implements JsonSerializable, ArrayAccess {
    use Traits\Storage;
    protected $tablename;
    protected $fields;

    protected function __construct()
    {
        $this->tablename = static::getTableName();
        $this->fields = static::getFields();
    }

    public function create() {
        $data_to_insert = [];
        $db = Database::getInstance()->direct();
        foreach ($this->fields as $key => $x) {
            $parts = explode("|", $x);
            $is_set = isset($this->data[$key]);
            if (!$is_set && !in_array("default", $parts)){
                // Поля нет в $data[] и у него нет значения по умолчанию.
                // База данных выдаст ошибку
                return null;
            }
            if ($is_set) {
                $data_to_insert[$key] = $db->real_escape_string($this->data[$key]);
                if (Database::isStringType(Database::getFieldType($parts))) {
                    $data_to_insert[$key] = "'".$data_to_insert[$key]."'";
                }
            }
        }

        $fields = implode(array_keys($data_to_insert), ","); // обернуть имена столбцов в '' ?
        $values = implode($data_to_insert, ",");
        $query = "INSERT INTO {$this->tablename} ($fields) VALUES($values)";
        $db->query($query);
    }

    public function jsonSerialize() {
        return $this->data;
    }

    public static function getFields() {
        return [];
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
