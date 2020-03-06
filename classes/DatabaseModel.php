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
        $primary_key_array = [];
        if (is_array($value)) {
            $primary_key_array = $value;
        } else {
            $primary_key_array[Database::getPrimaryKey(static::getFields())] = $value;
        }
        $builder = new QueryBuilder();
        $result = $builder->select("*")->from(static::getTableName())->where(static::whereCustomPrimary($primary_key_array))->execute();
        $objects = static::fetch($result);
        if (count($objects) > 0) {
            return $objects[0];
        }
        return null;
    }

    public static function whereCustomPrimary($data) {
        $fields = static::getFields();
        $primary_keys = [];
        foreach ($fields as $key => $x) {
            $parts = explode("|", $x);
            if (in_array("primary", $parts)) {
                $primary_keys[$key] = $data[$key];
            }
        }
        return implode(QueryBuilder::makePairs($primary_keys), " AND ");
    }

    public function wherePrimary() {
        return static::whereCustomPrimary($this->data);
    }

    public function save() {
        $data_to_update = [];
        foreach ($this->changed_fields as $key => $x) {
            $data_to_update[$key] = $this->data[$key];
        }
        $this->changed_fields = [];

        $builder = new QueryBuilder();
        $builder->update($this->tablename)->set($data_to_update)->where($this->wherePrimary())->execute();
    }

    public function delete() {
        $builder = new QueryBuilder();
        $builder->delete()->from($this->tablename)->where($this->wherePrimary())->execute();
    }

    public function check() {
        foreach ($this->fields as $key => $x) {
            $parts = explode("|", $x);
            $is_set = isset($this->data[$key]);
            if (!$is_set && !in_array("default", $parts)){
                // Поля нет в $data[] и у него нет значения по умолчанию.
                // База данных выдаст ошибку
                return false;
            }
        }
        return true;
    }

    public function create()
    {
        if ($this->check()) {
            $builder = new QueryBuilder();
            $builder->insert($this->tablename)->fields(array_keys($this->data))->values($this->data)->execute();

            foreach ($this->fields as $key => $value) {
                $parts = explode("|", $value);

                if (in_array("increment", $parts) && in_array("primary", $parts)) {
                    $this->data[$key] = Database::getInstance()->getLastInsertId();
                }
            }
            $this->changed_fields[] = "";
        }
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
            while($row = $result->fetch()) {
                array_push($objects, new static($row));
            }
        }
        return $objects;
    }

    public static function whereDateEq($date) {
        $builder = new QueryBuilder();
        $result = $builder->select("*")->from(static::getTableName())->where("date = '$date'")->execute();
        return static::fetch($result);
    }

    public static function all() {
        $builder = new QueryBuilder();
        $result = $builder->select("*")->from(static::getTableName())->execute();
        return static::fetch($result);
    }

    public function offsetSet($offset, $value) {
        if ($offset !== null) {
            if (isset($this->fields[$offset])) {
                $this->changed_fields[$offset] = true;
                $this->data[$offset] = $value;
            }
        }
    }
}
