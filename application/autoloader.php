<?php

/**
 * Set enviroment variables
 */
header("Content-Type: text/html ; charset=utf-8");
ini_set('memory_limit', '2048M');
set_time_limit(36000);
date_default_timezone_set('America/Mexico_City');
require_once str_replace("\\", "/",  dirname(__FILE__)) . "/../enviroment.php";

/**
 * Importing App Helpers
 */
require_once SERVER_APPLICATION_FOLDER . '/Core/Plain/helpers.php';


/**
 * Importing User Helper
 */
require_once SERVER_APPLICATION_FOLDER . '/Util/Helper/error.php';
require_once SERVER_APPLICATION_FOLDER . '/Util/Helper/log.php';
require_once SERVER_APPLICATION_FOLDER . '/Util/Helper/response.php';
require_once SERVER_APPLICATION_FOLDER . '/Util/Helper/string.php';


/**
 * Register class autoloader to make the namespaces work properly
 */
spl_autoload_register(
    function ($class)
    {
        $extension = ".php";
        $pathParts = explode("\\", $class);
        $pathParts[0] = strtolower($pathParts[0]);
        $namespaceFilePath = SERVER_ROOT_FOLDER . "/" . implode("/", $pathParts) . $extension;
        if( file_exists( $namespaceFilePath ) ){
            require_once $namespaceFilePath ;
        }else{
            error('Class not found! ' . $namespaceFilePath);
        }
    }
);