<?php

class Router {

    //assoc. array of routes (the routing table)
    protected $routes = [];

    //saved parameters from matched routes
    protected $params = [];

    /**
     * @param $route
     * @param array $params (controller, action, etc.)
     */
    public function add($route, $params = []) {

        //convert route to regex, escaping forward slashes throughout to prevent premature regex endings
        $route = preg_replace('/\//', '\\/', $route);

        //convert variables e.g. {controller} to (?P<controller>[a-z-]+)
        //when replacing, you can refer to capture groups using \1, \2 etc. for each capture group
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        //convert variables with custom regex, e.g. {id:\d+} to (?P<id>\d+)
        //whatever comes after : can be anything BUT a curly brace, as this would signal the end of the regex
        //if first character inside a capture group [] is the caret ^ , then that rejects anything in the group
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        //add start and end delimeters, and case insensitive flag
        $route = '/^' . $route . '$/i';

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

         foreach ($this->routes as $route => $params) {

             if (preg_match($route, $url, $matches)) {

                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $params[$key] = $match;
                        }
                    }

                    $this->params = $params;
                    return true;
                }

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