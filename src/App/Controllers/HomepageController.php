<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 30/01/19
 * Time: 11:49
 */

namespace App\Controllers;


use Core\BaseController;

class HomepageController extends BaseController
{
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    public function homepageAction()
    {
        $this->_twig->render('homepage.html.twig', array());
    }
}