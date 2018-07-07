<?php

namespace App\Controllers;

/**
 * Posts controller
 */
class Posts extends \Core\Controller  {

    /**
     * show the index page
     */
    public function index() {
        echo "Hello from the index action inside Posts controller!";
    }

    /**
     * show the add new page
     */
    public function addNew() {
        echo "Hello from the addNew action in the Posts controller!";
    }

    /**
     * Show the edit page
     *
     * @return void
     */
    public function edit()
    {
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' .
             htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}