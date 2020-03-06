<?php

namespace Data\Maria;

use Config;
use mysqli;

class Database extends \Singleton implements \Data\DatabaseInterface
{
    protected $db;
    public function __construct() {
        $config = Config::getInstance();
        $this->db = new mysqli($config["db_host"], $config["db_user"], $config["db_pass"], $config["db_name"]);

        if($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
        $this->db->set_charset('utf8');
    }

    public static function escape($string){
        return static::getInstance()->db->real_escape_string($string);
    }

    public function getLastInsertId() {
        return $this->db->insert_id;
    }

    public function query($q) {
        return new Result($this->db->query($q));
    }

    public function direct() {
        return $this->db;
    }
}