<?php

namespace App\Controllers;

use \Core\View;

/**
 * Posts controller
 */
class Posts extends \Core\Controller  {

    /**
     * show the index page
     */
    public function indexAction() {
        echo "Hello from the index action inside Posts controller!";
        View::renderTemplate('Posts/index.html');
    }

    /**
     * show the add new page
     */
    public function addNewAction() {
        echo "Hello from the addNew action in the Posts controller!";
    }

    /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' .
             htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}