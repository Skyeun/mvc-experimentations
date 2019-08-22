<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/12/18
 * Time: 16:59
 */

namespace Core\Controller;

use Core\TwigController;

abstract class AbstractController
{
    protected $_twig;

    protected function __construct()
	{
		$this->_twig = new TwigController();
	}
}