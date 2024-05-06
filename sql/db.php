<?php
class Db
{
    public static $db;

    public function __construct()
    {
        self::$db = new Mysql("localhost", "telecomlijn", "root", "");
    }
}

