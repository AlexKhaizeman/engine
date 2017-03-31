<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01/04/17
 * Time: 00:39
 */

namespace Engine\Template;


class Template
{
    protected $_path = '';

    public function __construct($config)
    {
        $this->_path = $config['path'];
    }

    public function render($template, $data)
    {
        $filename = $this->_path . DIRECTORY_SEPARATOR . $template . '.php';
        include($filename);
    }
}