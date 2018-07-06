<?php

/**
 * Front controller
 */

//Routing
require "../Core/Router.php";

$router = new Router();

//check to see if require is loading class
echo get_class($router);