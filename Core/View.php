<?php

namespace Core;

class View {

    /**
     * Renders a view file
     *
     * @param $view
     */
    public static function render($view) {

        //relative to core directory
        $file = "../App/Views/$view";

        //check file exists and is readable
        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found";
        }
    }
}