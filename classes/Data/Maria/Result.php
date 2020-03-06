<?php


namespace Data\Maria;


class Result implements \Data\Result
{
    protected $internal_result;
    public $num_rows;
    public function __construct($mysqli_result)
    {
        $this->internal_result = $mysqli_result;
        $this->num_rows = $mysqli_result->num_rows;
    }

    public function fetch() {
        return $this->internal_result->fetch_assoc();
    }
}
