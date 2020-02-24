<?php


class Database extends Singleton
{
    protected $db;
    protected function __construct() {
        $config = Config::getInstance();
        $this->db = new mysqli($config["db_host"], $config["db_user"], $config["db_pass"], $config["db_name"]);
        
        if($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
        parent::__construct();
    }

    public static function getFieldType($parts){
        $types = ["integer", "date", "boolean", "text", "varchar"];

        foreach ($parts as $key => $x) {
            if (in_array($x, $types)) {
                return $x;
            }
            $new_parts = explode(":", $x);
            if (in_array($new_parts[0], $types)) {
                return $new_parts[0];
            }
        }
        return null;
    }

    public static function isStringType($type){
        if ($type == "varchar" || $type == "text" || $type == "date") {
            return true;
        }
        return false;
    }

    public function direct() {
        return $this->db;
    }
}