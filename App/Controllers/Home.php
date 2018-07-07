<?php

namespace App\Controllers;

/**
 * Home controller
 */

class Home extends \Core\Controller {

    /**
     * show the index page
     */
    public function index() {
        echo "Hello from the index action in the Home controller!";
    }
}