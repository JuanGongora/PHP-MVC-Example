<?php

namespace Core;

use App\Config;
use PDO;

/**
 * Base model
 */
abstract class Model {

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB() {

        //variable retains its value after initial assignment, helping reduce repetitive instantiation of DB
        static $db = null;

        if ($db === null) {

                //data source name compilation string, which is then added to the instantiated $db
                $dsn = "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=utf8";

                //all settings are dynamically referenced from class Config to prevent hard coding
                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}