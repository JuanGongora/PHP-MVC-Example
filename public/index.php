<?php

/**
 * Front controller
 */

//Routing
require "../Core/Router.php";

$router = new Router();

//add the routes, it's common to add specific routes first, then the more generalized routes at the end:
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');

// Display the routing table
echo '<pre>';
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';

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