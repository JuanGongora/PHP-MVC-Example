<?php

namespace Core;

// #=> https://stackoverflow.com/questions/2558559/what-is-abstract-class-in-php
abstract class Controller {

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {

            //checks first to see that before() method is callable on object
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            //construct the exception, note: the message is NOT binary safe
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method, abstracted method
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method, abstracted method
     *
     * @return void
     */
    protected function after()
    {
    }
}