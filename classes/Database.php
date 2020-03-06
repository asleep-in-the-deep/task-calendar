<?php


class Database extends Singleton
{
    protected $database_interface;
    protected function __construct() {
        $config = Config::getInstance();
        if ($config["db_driver"] == "mysql") {
            $this->database_interface = new Data\Maria\Database();
        } else if ($config["db_driver"] == "sqlite") {
            $this->database_interface = new Data\Lite\Database();
        } else {
            throw new Exception("Неизвестный db_driver.");
        }
        parent::__construct();
    }

    public static function getAutoincrement() {
        return static::getInstance()->direct()::getAutoincrement();
    }

    public static function escape($string){
        return static::getInstance()->direct()::escape($string);
    }

    public static function getFieldType($parts){
        $types = ["integer", "date", "boolean", "text", "varchar", "float"];
        $types_table = ["integer" => "INTEGER", "date" => "DATE", "boolean" => "TINYINT(1)", "text" => "TEXT", "varchar" => "VARCHAR", "float" => "FLOAT"];

        foreach ($parts as $key => $x) {
            if (in_array($x, $types)) {
                return $types_table[$x];
            }
            $new_parts = explode(":", $x);
            if (in_array($new_parts[0], $types)) {
                if ($new_parts == "varchar"){
                    return $types_table[$x]."({$new_parts[1]})";
                }
                return $types_table[$new_parts[0]];
            }
        }
        return null;
    }

    public static function isPrimary($parts) {
        return in_array("primary", $parts);
    }

    public static function isIncrement($parts) {
        return in_array("increment", $parts);
    }

    public static function isNotNull($parts) {
        return in_array("not_null", $parts);
    }

    public static function hasDefault($parts) {
        foreach ($parts as $key => $x) {
            $new_parts = explode(":", $x);
            if ($new_parts[0] == "default") {
                return true;
            }
        }
        return false;
    }

    public static function getDefault($parts) {
        foreach ($parts as $key => $x) {
            $new_parts = explode(":", $x);
            if ($new_parts[0] == "default") {
                if (!isset($new_parts[1])) return null;
                return $new_parts[1];
            }
        }
        return null;
    }

    public static function getPrimaryKey($fields){
        foreach ($fields as $key => $x) {
            $parts = explode("|", $x);
            if (in_array("primary", $parts)) {
                return $key;
            }
        }
        return null;
    }

    public function getLastInsertId() {
        return $this->database_interface->getLastInsertId();
    }

    public function query($query) {
        return $this->database_interface->query($query);
    }

    public function direct() {
        return $this->database_interface;
    }
}