<?php

namespace Application\Core;

use ReflectionMethod;
use ReflectionParameter;

define('CONTROLLER_NAMESPACE', "Application\\Http\\Controller\\");
define('MAIN_VALIDATOR_FUNCTION', "validate");
define('CONTROLLER_ROUTE_KEYWORD', 'controller');
define('CONTROLLER_METHOD_DELIMITER', '@');
define('VALIDATOR_ROUTE_KEYWORD', 'validator');
define('METHOD_ROUTE_KEYWORD', 'method');
define('POST_ROUTER_METHOD', 'POST');
define('PATCH_ROUTER_METHOD', 'PATCH');
define('GET_ROUTER_METHOD', 'GET');
define('DELETE_ROUTER_METHOD', 'DELETE');

class Router {

    private static $instance;
    private $routes;
    private $url;
    private $method;

    /**
     * Initialize router
     */
    private function __construct() {
        $this->routes = array();
        $this->url = array_shift(explode("?", filter_input(INPUT_SERVER, 'REQUEST_URI')));
        $this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    }

    /**
     * Returns instance of singleton
     * @return Router
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    /**
     * set url
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * returns url
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * sets method
     * @param string $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * gets method
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * stores the url and associates it to a post method
     * @param string $route
     * @param string $controller
     */
    public function post($route, $controller) {
        $this->assign(POST_ROUTER_METHOD, $route, $controller);
    }

    /**
     * stores the url and associates it to a patch method
     * @param string $route
     * @param string $controller
     */
    public function patch($route, $controller) {
        $this->assign(PATCH_ROUTER_METHOD, $route, $controller);
    }

    /**
     * stores the url and associates it to a get method
     * @param string $route
     * @param string $controller
     */
    public function get($route, $controller) {
        $this->assign(GET_ROUTER_METHOD, $route, $controller);
    }

    /**
     * stores the url and associates it to a delete method
     * @param string $route
     * @param string $controller
     */
    public function delete($route, $controller) {
        $this->assign(DELETE_ROUTER_METHOD, $route, $controller);
    }

    /**
     * execute the indicate controller with the url and method
     * @param string $route
     * @param string $controller
     */
    public function dispatch() {
        $url = "/" . str_replace("/" . PAGE_ROOT_FOLDER_NAME . "/", "", $this->url);
        $method = $this->method;
        if (isset($this->routes[$url]) && isset($this->routes[$url][$method])) {
            $controllerClass = $this->routes[$url][$method][CONTROLLER_ROUTE_KEYWORD];
            $method = $this->routes[$url][$method][METHOD_ROUTE_KEYWORD];
            $this->invoke($controllerClass, $method);
        } else {
            echo "404";
        }
    }

    /**
     * actual storing of the url 
     * @param string $httpMethod
     * @param string $route
     * @param string $controller
     */
    private function assign($httpMethod, $route, $controller) {
        $items = explode(CONTROLLER_METHOD_DELIMITER, $controller);
        $class = $items[0];
        $method = $items[1];
        $routeWithFolder = $route;

        $action = [CONTROLLER_ROUTE_KEYWORD => $class, METHOD_ROUTE_KEYWORD => $method];

        if (isset($this->routes[$routeWithFolder])) {
            $this->routes[$routeWithFolder] = array_merge($this->routes[$routeWithFolder], [$httpMethod => $action]);
        } else {
            $this->routes[$routeWithFolder] = [$httpMethod => $action];
        }
    }

    /**
     * Call the controller with validations if any
     * @param string $controllerClass
     * @param string $method
     */
    private function invoke($controllerClass, $method) {
        $fullControllerClass = CONTROLLER_NAMESPACE . $controllerClass;
        $controller = new $fullControllerClass();

        $classMethod = new ReflectionMethod($fullControllerClass, $method);
        $argumentCount = count($classMethod->getParameters());
        if ($argumentCount > 0) {
            $requestParam = new ReflectionParameter(array($fullControllerClass, $method), 0);
            $fullValidatorClass = $requestParam->getClass()->getName();
            $validator = new $fullValidatorClass();
            $validator->{MAIN_VALIDATOR_FUNCTION}();
            $controller->{$method}($validator);
        } else {
            $controller->{$method}();
        }
    }

}
