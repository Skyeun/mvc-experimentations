<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/12/18
 * Time: 16:59
 */

namespace Core;

class BaseController
{
    protected $_twig;

    protected function init()
    {
        $this->_twig = new TwigController();
    }
}