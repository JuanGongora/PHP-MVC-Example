<?php

/**
 * Front controller
 */

//Controller
require "../App/Controllers/Posts.php";

//Routing
require "../Core/Router.php";

$router = new Router();

//add the routes, it's common to add specific routes first, then the more generalized routes at the end:
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');

//uses matching routes with active classes/methods
$router->dispatch($_SERVER['QUERY_STRING']);