<?php


class QueryBuilder
{
    protected $fields;
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
            return Database::getInstance()->direct()->query($query);
        }
    }
}