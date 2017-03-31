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

class Application
{
    protected $_config = [];

    protected $_database = null;

    protected $_template = null;

    protected $_router = null;

    protected static $_instance = null;

    public function __construct($config = [])
    {
        $this->_config = $config;

        $this->initDatabase(isset($config['database']) ? $config['database'] : []);
        $this->initTemplate(isset($config['template']) ? $config['template'] : []);
        $this->initRouter(isset($config['router']) ? $config['router'] : []);
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

    }
}