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
     * @throws \Exception
     */
    public function dispatch($url) {

        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);

            //namespacing for Controllers dir to see if a class exists in its scope
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params["action"];

                //forming the instance method to call from the collected action
                $action = $this->convertToCamelCase($action);

                //prevents unathorized access to methods by suffixing the Action string in the url
                //since url calls to actions are just the prefix, and the suffix is only added at __call() in Controller
                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    //construct the exception, note: the message is NOT binary safe
                    throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }

            } else {
                throw new \Exception("Controller class $controller not found");
            }

        } else {
            throw new \Exception('No route matched.', 404);
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

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {

            //split string to array with limit of 2 elements, with last element being the full remainder of string after &
            $parts = explode('&', $url, 2);

            //find the position of the first occurrence of '=' if it exists
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class.
     * The namespace defined in the route table parameters is added if present.
     *
     * @return string The request URL
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {

            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}