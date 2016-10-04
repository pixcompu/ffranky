<?php
/**
 * There is a diference beetwen server and client, because client manages the navigator route
 * while server manages the file route internally in the file system
 */
define('PAGE_ROOT_FOLDER_NAME', 'mvc-template');

/**
 * Root file routes, the BACKEND is based on this routes
 */
define('SERVER_ROOT_FOLDER', str_replace("\\", "/",  dirname(__FILE__)));
define('SERVER_APPLICATION_FOLDER', SERVER_ROOT_FOLDER . "/application");
define('SERVER_PUBLIC_FOLDER', SERVER_ROOT_FOLDER . "/public");
define('SERVER_VIEWS_FOLDER', SERVER_ROOT_FOLDER . "/view");
define('SERVER_DOWNLOAD_FOLDER', SERVER_PUBLIC_FOLDER . "/resources/downloads");

/**
 * Root domain routes, the FRONTEND is based on this routes
 */
define('CLIENT_ROOT_FOLDER', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']  . "/" . PAGE_ROOT_FOLDER_NAME );
define('CLIENT_PUBLIC_FOLDER', CLIENT_ROOT_FOLDER . "/public");
define('CLIENT_PUBLIC_STYLE_FOLDER', CLIENT_PUBLIC_FOLDER . "/style");
define('CLIENT_PUBLIC_SCRIPT_FOLDER', CLIENT_PUBLIC_FOLDER . "/script");
define('CLIENT_VIEW_FOLDER', CLIENT_ROOT_FOLDER . "/view");
define('CLIENT_DOWNLOAD_FOLDER', CLIENT_PUBLIC_FOLDER . "/resources/downloads" );
