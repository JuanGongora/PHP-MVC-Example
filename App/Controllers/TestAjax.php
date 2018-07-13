<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;

class TestAjax extends \Core\Controller  {

    public function testingAction() {
        $register = User::authenticate();
        return $register;

    }

    public static function indexAction() {
        $message = User::getMessage();
        View::renderTemplate('Users/index.html');

    }

    public static function chatAction() {
        $users = User::getAll();
        View::renderTemplate('chat.html', ['users' => $users]);
    }
}
