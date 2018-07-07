<?php

namespace App\Controllers;

/**
 * Posts controller
 */
class Posts {

    /**
     * show the index page
     */
    public function index() {
        echo "Hello from the index action inside Posts controller!";
        echo '<p>Query string parameters: <pre>' .
            htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
    }

    /**
     * show the add new page
     */
    public function addNew() {
        echo "Hello from the addNew action in the Posts controller!";
    }
}