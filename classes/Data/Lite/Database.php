<?php

namespace Data\Lite;

use Config;
use mysqli;

class Database extends \Singleton implements \Data\DatabaseInterface
{
    protected $db;
    public function __construct() {
        $config = Config::getInstance();
        $this->db = new \SQLite3($config["db_file"]);
    }

    public static function getAutoincrement() {
        return "AUTOINCREMENT";
    }

    public static function escape($string){
        return static::getInstance()->db::escapeString($string);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertRowID();
    }

    public function query($q) {
        return new Result($this->db->query($q));
    }

    public function direct() {
        return $this->db;
    }
}