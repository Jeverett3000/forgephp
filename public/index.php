<?php

// define the local directory
define( 'FORGE\BASE', realpath(  __DIR__ . '/..'  ) . '/' );
define( 'FORGE\APP', FORGE\BASE . 'application/' );
define( 'FORGE\VENDOR', realpath( FORGE\BASE . 'vendor' )  . '/' );
define( 'FORGE\FOUNDATION', FORGE\VENDOR . 'forgephp/foundation/' );

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

if ( ! function_exists('__'))
{
    /**
     * Foundation variable replacement function. The PHP function
     * [strtr](http://php.net/strtr) is used for replacing parameters.
     *
     *    __('Welcome back, :user', array(':user' => $username));
     *
     * @param   string  $string text
     * @param   array   $values values to replace
     * @return  string
     */
    function __( $string, array $values=NULL )
    {
        return empty( $values ) ? $string : strtr( $string, $values );
    }
}

// register autoloader
require FORGE\VENDOR . 'autoload.php';

// and start up the system.
require FORGE\APP . 'bootstrap.php';
