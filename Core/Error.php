<?php

namespace Core;

/**
 * Error and exception handler
 */
class Error {

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line) {

        //sets which PHP errors are reported by numerical value, here we compare to 0
        if (error_reporting() !== 0) {

            //constructs the exception
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler, contains methods from Error and Exception which are callable due to set
     * also allows for error logging even if in production, by having them written to server file
     *
     * @param $exception
     *
     * @return void
     */
    public static function exceptionHandler($exception) {

        //code is 404(not found) or 500(general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }

        //get or set the http response code
        http_response_code($code);

        //checks if constant is set to true
        if (\App\Config::SHOW_ERRORS) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {

            //returns directory name component of path
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';

            //setting temporary error_log in php.ini config path for the length of script
            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($exception) . "'";

            //adding to the $message variable
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

            //sends an error message to the web server's error log or to a file
            error_log($message);

            //renders the twig file
            View::renderTemplate($code . ".html");
        }
    }
}