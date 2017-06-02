<?php

namespace App;

use \Forge\Route;
use \Forge\Debug;
use \Forge\Request;
use \Forge\Foundation;
use \Forge\Config\File as Config_File;

/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 */
define( 'EXT', '.php' );

// Set the default time zone.
date_default_timezone_set( 'GMT' );

/**
 * Define the start time of the application, used for profiling.
 */
if( ! defined( 'Forge\\START_TIME' ) )
{
    define( 'Forge\\START_TIME', microtime( TRUE ) );
}

/**
 * Define the memory usage at the start of the application, used for profiling.
 */
if( ! defined( 'Forge\\START_MEMORY' ) )
{
    define('Forge\\START_MEMORY', memory_get_usage() );
}

/**
 * Set Foundation::$environment if a 'SUPERFAN_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Foundation::<INVALID_ENV_NAME>"
 */
if( isset( $_SERVER['FORGE_ENV'] ) )
{
    Foundation::$environment = constant( 'Foundation::' . strtoupper( $_SERVER['FORGE_ENV'] ) );
}

// Set the default locale.
setlocale( LC_ALL, 'en_US.utf-8' );

// Enable the foundation auto-loader for unserialization.
// ini_set( 'unserialize_callback_func', 'spl_autoload_call' );

// Set the mb_substitute_character to "none"
mb_substitute_character('none');

/*
 * Start Foundation, setting the default options.
 *
 * The following options are available:
 *
 * - string   charset     internal character set used for input and output   utf-8
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        TRUE
 */
Foundation::start();

// attach a log class
//Foundation::$log->attach( new Log_Database( 'syslog' ) );

// attach the file config source
Foundation::$config->attach( new Config_File );

// calling a minion task
if( defined( 'Forge\\MINION' ) && \Forge\MINION === TRUE )
{
    set_exception_handler(array('\Forge\Minion\Exception', 'handler'));

    \Forge\Minion\Task::factory( \Forge\Minion\CLI::options() )->execute();
}

// calling a web request
else
{
    // load the routes
    Route::run( 'web' );

    // Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
    // If no source is specified, the URI will be automatically detected.
    echo Request::factory( TRUE, array() )
        ->execute()
        // ->send_headers()
        // ->body()
    ;
}
