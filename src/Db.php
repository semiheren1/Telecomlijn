<?php

namespace Parkeren;

class Db
{
    public static $db;

    public function __construct()
    {
        // Initialize the database connection using the Mysql class
        try {
            self::$db = new Mysql("localhost", "telecomlijn", "root", "");
        } catch (\Exception $e) {
            // Handle any exceptions thrown during database connection initialization
            throw new \Exception("Database connection error: " . $e->getMessage());
        }
    }
}
