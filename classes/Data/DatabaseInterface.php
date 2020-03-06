<?php

namespace Data;

interface DatabaseInterface
{
    public static function escape($string);
    public function getLastInsertId();
    public function query($q);
}
