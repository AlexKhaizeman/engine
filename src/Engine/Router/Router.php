<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01/04/17
 * Time: 00:39
 */

namespace Engine\Router;


class Router
{
    protected $_routes;

    public function __construct($config)
    {
        $this->_routes = $config['routes'];
    }

    public function match($path)
    {
        foreach ($this->_routes as $name => $route) {
            if ($path == $name) {
                forward_static_call($route);
                return true;
            }
        }

        return false;
    }
}