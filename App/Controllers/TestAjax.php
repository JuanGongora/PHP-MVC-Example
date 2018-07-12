<?php

namespace App\Controllers;

class TestAjax extends \Core\Controller  {

    public function testingAction() {
       echo $_GET['name'];
    }

}
