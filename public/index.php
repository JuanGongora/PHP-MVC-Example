<?php

/**
 * Front controller
 */

/**
 * Twig
 */
require_once dirname(__DIR__) . '/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

/**
 * Autoloader
 */
spl_autoload_register(function ($class) {
    //get the parent directory
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    //checks if file exists and is readable
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

$router = new Core\Router();

//add the routes, it's common to add specific routes first, then the more generalized routes at the end:
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

//uses matching routes with active classes/methods
$router->dispatch($_SERVER['QUERY_STRING']);