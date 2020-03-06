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

    public static function escape($string){
        return static::getInstance()->direct()::escape($string);
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