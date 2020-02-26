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
        $this->db->set_charset('utf8');
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

    public static function getPrimaryKey($fields){
        foreach ($fields as $key => $x) {
            $parts = explode("|", $x);
            if (in_array("primary", $parts)) {
                return $key;
            }
        }
        return null;
    }

    public function direct() {
        return $this->db;
    }
}