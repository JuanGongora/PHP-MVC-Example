<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Post model
 */
class Post extends \Core\Model {

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll() {

        try {

            $db = static::getDB();

            $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');

            //returns row as an array indexed by column name
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}