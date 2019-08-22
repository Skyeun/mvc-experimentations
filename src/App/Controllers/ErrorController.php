<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 09:23
 */

namespace App\Controllers;


use Core\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function NoRouteAction() {
        $this->_twig->render('error.html.twig', array(
            'errorCode' => 404,
            'errorMessage' => "Page not found"
        ));
    }
}