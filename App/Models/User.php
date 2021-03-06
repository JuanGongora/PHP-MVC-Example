<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * User model
 */
class User extends \Core\Model {

    /**
     * inserts into DB new user unless they are already a member
     *
     */
    public static function authenticate() {

        try {

            //calling the inherited method from Model, that resides in the current class
            $db = static::getDB();

            //arguments passed in from ajax requested form
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];

            $sql = "SELECT * FROM users WHERE email = :email";

            $stmt = $db->prepare($sql);

            $stmt->bindValue(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            //returns the number of rows affected by the last SQL statement
            $check_email = $stmt->rowCount();


            if($check_email){
                echo "<h2>This email is already registered, please try another!</h2>";
                exit();
            } else {

                $sql = "INSERT INTO users (id, name, pass, email) VALUES (NULL, :name, :pass, :email)";

                $stmt = $db->prepare($sql);

                $stmt->bindValue(":name", $name, PDO::PARAM_STR);
                $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "<h2>Registration Successful, thanks!</h2>";
                }
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getAll() {

        try {

            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM chat ORDER BY id DESC');

            //returns row as an array indexed by column name
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getMessage() {

        try {

            $db = static::getDB();

            if (isset($_POST['submit']) && !empty($_POST['name'])) {

                $name = $_POST['name'];
                $msg = $_POST['msg'];

                $sql = "INSERT INTO chat (id, name, msg, date) VALUES (NULL, :name, :msg, CURRENT_TIMESTAMP)";

                $stmt = $db->prepare($sql);

                $stmt->bindValue(":name", $name, PDO::PARAM_STR);
                $stmt->bindValue(":msg", $msg, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "<embed loop='false' src='sound' hidden='true' autoplay='true' />";
                }
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}