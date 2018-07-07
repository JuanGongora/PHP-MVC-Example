<?php

//the folder Core is now namespaced
namespace Core;

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

            //the $route is what's input on the route table, with $url being the input on the browser url string
            //the result set is then assigned to $matches
            if (preg_match($route, $url, $matches)) {

                foreach ($matches as $key => $match) {

                    //$matches array contains keys that are integers which hold result set strings after regex conversion
                    //with the only key strings being controllers/actions
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

    /**
     * dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url) {

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);

            //namespacing for Controllers dir to see if a class exists in its scope
            $controller = "App\Controllers\\{$controller}";

            if (class_exists($controller)) {
                $controller_object = new $controller();

                $action = $this->params["action"];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {

                    $controller_object->$action();

                } else {
                    echo "Method {$action} (in controller {$controller}) not found";
                }
            } else {
                echo "Controller class {$controller} not found";
            }

        } else {
            echo "No route matched";
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }
}