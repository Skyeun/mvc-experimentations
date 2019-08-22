<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 30/01/19
 * Time: 11:49
 */

namespace App\Controllers;


use Core\Controller\AbstractController;

class HomepageController extends AbstractController
{
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function homepageAction()
    {
        $this->_twig->render('homepage.html.twig', array());
    }
}