<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01/04/17
 * Time: 00:38
 */

namespace Engine\Controller;


use Engine\Application\Application;

class Controller
{
    public static function render($template, $data = [])
    {
        return Application::getInstance()->getTemplate()->render($template, $data);
    }
}