<?php

namespace Core;

class View {

    /**
     * Renders a view file
     *
     * @param $view
     */
    public static function render($view, $args = []) {

        extract($args, EXTR_SKIP);

        //relative to core directory
        $file = "../App/Views/$view";

        //check file exists and is readable
        if (is_readable($file)) {
            require $file;
        } else {
            //construct the exception, note: the message is NOT binary safe
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = []) {

        //variable which retains its value after execution
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}