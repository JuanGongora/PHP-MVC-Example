<?php

namespace App\Models;

use PDO;

/**
 * Post model
 */
class Post {

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll() {

        $host = 'localhost';
        $dbname = 'mvc';
        $username = 'root';
        $password = '';

        try {

            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                $username, $password);

            $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');

            //returns row as an array indexed by column name
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}