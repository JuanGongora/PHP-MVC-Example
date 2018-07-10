<?php

/**
 * Front controller
 */

//autoloads all our content through composer.json parameters
require '../vendor/autoload.php';

/**
 * Twig
 */
Twig_Autoloader::register();

$router = new Core\Router();

//add the routes, it's common to add specific routes first, then the more generalized routes at the end:
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

//uses matching routes with active classes/methods
$router->dispatch($_SERVER['QUERY_STRING']);