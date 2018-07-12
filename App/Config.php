<?php

namespace App;

/**
 * Class Config
 * @package App
 *
 * this class is used to change database settings when migrating to another server
 */
class Config {

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mvc';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * should be set to false when in production
     *
     * @var boolean
     */
    const SHOW_ERRORS = true;
}