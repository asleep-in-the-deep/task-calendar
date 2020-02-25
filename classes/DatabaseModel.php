<?php

class DatabaseModel implements JsonSerializable, ArrayAccess {
    use Traits\Storage;
    protected $tablename;
    protected $fields;
    protected $changed_fields = [];

    protected function __construct()
    {
        $this->tablename = static::getTableName();
        $this->fields = static::getFields();
    }

    public static function get($value) {
        $tablename = static::getTableName();
        $primary_key_array = [];
        if (is_array($value)) {
            $primary_key_array = $value;
        } else {
            $primary_key_array[Database::getPrimaryKey(static::getFields())] = $value;
        }
        $query = "SELECT * FROM `$tablename` WHERE ".static::whereCustomPrimary($primary_key_array);
        $result = Database::getInstance()->direct()->query($query);
        $objects = static::fetch($result);
        if (count($objects) > 0) {
            return $objects[0];
        }
        return null;
    }

    public static function whereCustomPrimary($data) {
        $db = Database::getInstance()->direct();
        $fields = static::getFields();
        $primary_keys = [];
        foreach ($fields as $key => $x) {
            $parts = explode("|", $x);
            if (in_array("primary", $parts)) {
                $primary_keys[$key] = $db->real_escape_string($data[$key]);
            }
        }
        return implode(static::makePairs($primary_keys), " AND ");
    }

    public function wherePrimary() {
        return static::whereCustomPrimary($this->data);
    }

    public static function makePairs($pairs) {
        $fields = static::getFields();
        $output = [];
        foreach ($pairs as $key => $value) {
            $x = $fields[$key];
            $parts = explode("|", $x);
            if (Database::isStringType(Database::getFieldType($parts))) {
                $value = "'".$value."'";
            }

            $output[] = "$key=$value";
        }
        return $output;
    }

    public function save() {
        $db = Database::getInstance()->direct();
        $data_to_update = [];
        foreach ($this->changed_fields as $key => $x) {
            $data_to_update[$key] = $db->real_escape_string($this->data[$key]); // что если ключа нет в $this->fields ?
        }
        $this->changed_fields = [];

        $set_string = implode(static::makePairs($data_to_update), ", ");
        $query = "UPDATE {$this->tablename} SET $set_string WHERE ".$this->wherePrimary();
        $db->query($query);
    }

    public function delete() {
        $db = Database::getInstance()->direct();
        $query = "DELETE FROM {$this->tablename} WHERE ".$this->wherePrimary();
        $db->query($query);
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
        $db->query($query); // TODO: сохранить первичный ключ, если это счётчик
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

    public function offsetSet($offset, $value) {
        if ($offset !== null) {
            $this->changed_fields[$offset] = true;
            $this->data[$offset] = $value;
        }
    }
}
