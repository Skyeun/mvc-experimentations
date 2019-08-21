<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/12/18
 * Time: 17:04
 */

namespace Core;

use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigController
{
    private $_twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');

        // Place cache later
        $this->_twig = new Twig_Environment($loader, array());
    }

    public function render($template, $parameters)
    {
        echo $this->_twig->render($template, $parameters);
    }
}