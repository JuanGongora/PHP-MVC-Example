<?php

class Router {

    //assoc. array of routes (the routing table)
    protected $routes = [];

    //saved parameters from matched routes
    protected $params = [];

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
    public function getRoutes() {

        return $this->routes;
    }

    /**
     * match the route to one from the routing table, setting $params for it if true
     *
     * @param $url
     * @return bool
     */
    public function match($url) {

        //match the fixed url format to /controller/action
        $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/"; //https://www.phpliveregex.com/

        if (preg_match($reg_exp, $url, $matches)) {

            //get named capture group values
            $params = [];

            foreach ($matches as $key => $match) {
                if (is_string($key)) {
                    $params[$key] = $match;
                }
            }

            $this->params = $params;
            return true;
        }

        return false;
    }

    /**
     * gets the currently matched parameters
     *
     * @return array
     */
    public function getParams() {

        return $this->params;
    }
}