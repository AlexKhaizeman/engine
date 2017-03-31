<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01/04/17
 * Time: 00:35
 */

namespace Engine\Application;

use Engine\Database\Database;
use Engine\Router\Router;
use Engine\Template\Template;
use Exception;

class Application
{
    protected $_config = [];

    /**
     * @var Database
     */
    protected $_database = null;

    /**
     * @var Template
     */
    protected $_template = null;

    /**
     * @var Router
     */
    protected $_router = null;

    protected static $_instance = null;

    public function __construct($config = [])
    {
        $this->_config = $config;

        $this->initDatabase(isset($config['database']) ? $config['database'] : []);
        $this->initTemplate(isset($config['template']) ? $config['template'] : []);
        $this->initRouter(isset($config['router']) ? $config['router'] : []);
    }

    public function getDb()
    {
        return $this->_database;
    }

    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * @param array $config
     * @return self
     */
    public static function getInstance($config = [])
    {
        if (!static::$_instance) {
            static::$_instance = new static($config);
        }
        return static::$_instance;
    }

    protected function initDatabase($config = [])
    {
        $this->_database = new Database($config);
    }

    protected function initTemplate($config = [])
    {
        $this->_template = new Template($config);
    }

    protected function initRouter($config = [])
    {
        $this->_router = new Router($config);
    }


    public function run()
    {
        if (!$this->_router->match($this->getPath())) {
            $this->error();
        };
    }

    public function getUrl()
    {
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // IIS
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            if ($requestUri !== '' && $requestUri[0] !== '/') {
                $requestUri = preg_replace('/^(http|https):\/\/[^\/]+/i', '', $requestUri);
            }
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0 CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            throw new Exception('Unable to determine the request URI.');
        }
        return $requestUri;
    }

    public function getPath()
    {
        return strtok($this->getUrl(), '?');
    }

    public function error()
    {
        if (!headers_sent()) {
            header("HTTP/1.0 404 Not Found");
        }

        echo 'Page not found :\'(';
    }
}