<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 09:23
 */

namespace App\Controllers;


use Core\BaseController;

class ErrorController extends BaseController
{
    public function __construct()
    {
        $this->init();
    }

    public function NoRouteAction() {
        $this->_twig->render('error.html.twig', array(
            'errorCode' => 404,
            'errorMessage' => "Page not found"
        ));
    }
}