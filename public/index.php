<?php

/**
 * Front controller
 */

//Routing
require "../Core/Router.php";

$router = new Router();

//add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);

//match the requested route
$url = $_SERVER['QUERY_STRING'];

//display routing table
if ($router->match($url)) {
    echo "<pre>";
    var_dump($router->getParams());
    echo "</pre>";
} else {
    echo "No route found for URL '{$url}'";
}