<?php


namespace Data\Lite;


class Result implements \Data\Result
{
    protected $internal_result;
    public $num_rows;
    public function __construct($sqlite_result)
    {
        $this->internal_result = $sqlite_result;
        if ($sqlite_result) {
            $this->num_rows = $sqlite_result->numColumns();
        }
    }

    public function fetch() {
        return $this->internal_result->fetchArray( SQLITE3_ASSOC );
    }
}
