<?php

namespace Core;

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
            $host = 'localhost';
            $dbname = 'mvc';
            $username = 'root';
            $password = '';

            try {
                $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                    $username, $password);

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return $db;
    }
}