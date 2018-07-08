<?php

namespace App\Controllers\Admin;

/**
 * User admin controller
 *
 * @package App\Controllers\Admin
 */
class Users extends \Core\Controller {

    /**
     * Before filter
     *
     * @return void
     */
    protected function before() {
        //make sure an admin user is logged in for example
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction() {

        echo "User admin index";
    }

}