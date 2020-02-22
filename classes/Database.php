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

    public function direct() {
        return $this->db;
    }
}