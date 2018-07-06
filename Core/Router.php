<?php

class Router {

    //assoc. array of routes (the routing table)
    protected $routes = [];

    /**
     * @param $route
     * @param $params (controller, action, etc.)
     */
    public function add($route, $params) {

        $this->routes[$route] = $params;
    }

    /**
     * gets all routes from the routing table
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

}