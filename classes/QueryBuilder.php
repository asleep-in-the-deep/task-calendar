<?php


class QueryBuilder
{
    protected $fields;
    protected $values;
    protected $tablename;
    protected $where = null;
    protected $type;
    public function __construct()
    {
    }

    public function select($what) {
        $this->type = "select";
        $this->fields = $what;
        return $this;
    }

    public function insert($tablename) {
        $this->type = "insert";
        $this->tablename = Database::escape($tablename);
        return $this;
    }

    public function update($tablename) {
        $this->type = "update";
        $this->tablename = Database::escape($tablename);
        return $this;
    }

    public function createTable($tablename) {
        $this->type = "create";
        $this->tablename = Database::escape($tablename);
        return $this;
    }

    public function fieldsTable($fields) {
        $this->fields = $fields;
        return $this;
    }

    public function fields($fields) {
        $this->fields = [];
        foreach ($fields as $key => $value) {
            $this->fields[$key] = "`".Database::escape($value)."`";
        }
        return $this;
    }

    public function set($data_to_update) {
        $set_string = implode(static::makePairs($data_to_update), ", ");
        $this->values = $set_string;
        return $this;
    }

    public function values($values) {
        $this->values = [];
        foreach ($values as $key => $value) {
            $this->values[$key] = "'".Database::escape($value)."'";
        }
        return $this;
    }

    public function delete() {
        $this->type = "delete";
        return $this;
    }

    public function from($tablename) {
        $this->tablename = Database::escape($tablename);
        return $this;
    }

    public function where($where) {
        $this->where = $where;
        return $this;
    }

    public function execute() {
        if ($this->type === "select") {
            $complex_where = "";
            if ($this->where !== null) {
                $complex_where = " WHERE $this->where";
            }
            $query = "SELECT $this->fields FROM `$this->tablename`".$complex_where;
            return Database::getInstance()->query($query);
        } else if ($this->type === "insert") {
            $fields = implode(",", $this->fields);
            $values = implode(",", $this->values);
            $query = "INSERT INTO `$this->tablename` ($fields) VALUES($values)";
            return Database::getInstance()->query($query);
        } else if ($this->type === "delete") {
            $complex_where = "";
            if ($this->where !== null) {
                $complex_where = " WHERE $this->where";
            }
            $query = "DELETE FROM `$this->tablename`".$complex_where;
            return Database::getInstance()->query($query);
        } else if ($this->type === "update") {
            $complex_where = "";
            if ($this->where !== null) {
                $complex_where = " WHERE $this->where";
            }
            $query = "UPDATE `$this->tablename` SET $this->values".$complex_where;
            return Database::getInstance()->query($query);
        } else if ($this->type === "create") {
            $table_fields_array = [];

            foreach ($this->fields as $key => $value) {
                $x = explode("|", $value);
                $escaped_field = Database::escape($key);
                $type = Database::getFieldType($x);
                $string = "`$escaped_field` $type";

                if (Database::isPrimary($x)) $string .= " PRIMARY KEY";
                if (Database::isIncrement($x)) $string .= " ".Database::getAutoincrement();
                if (Database::isNotNull($x)) $string .= " NOT NULL";
                if (($v = Database::getDefault($x)) != null) {
                    $escaped =  Database::escape($v);
                    $string .= " DEFAULT '$escaped'";
                }

                $table_fields_array[] = $string;
            }
            $table_fields = implode(",", $table_fields_array);
            $query = "CREATE TABLE `$this->tablename` ($table_fields)";
            return Database::getInstance()->query($query);
        }
    }

    public static function makePairs($pairs) {
        $output = [];
        foreach ($pairs as $key => $value) {
            $x = Database::escape($value);
            $output[] = "$key='$x'";
        }
        return $output;
    }
}