<?php

namespace App\Controllers;

use App\Managers\UserManager;
use App\Models\Session;
use App\Models\User;
use Core\BaseController;

/**
 * Class LoginController
 * @package App\Controllers
 */
class LoginController extends BaseController {

    /**
     * @var UserManager
     */
    private $_manager;
    private $_session;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->init();

        $this->_manager = new UserManager();
        $this->_session = new SessionController();
    }

    /**
     * Handle the connexion of a user
     */
    public function connectAction()
    {
        $errors = [];

        if (session_status() == PHP_SESSION_NONE) {
            if (!isset($_POST['submit']))
                $this->_twig->render('login.html.twig', array());
            else {

                if (!isset($_POST['login']) || is_null($_POST['login']))
                    $errors['login'] = "A login need to be provided.";
                if (!isset($_POST['password']) || is_null($_POST['password']))
                    $errors['password'] = "A password need to be provided.";

                if (count($errors) === 0) {
                    $data = $this->_manager->search(
                        array("pseudo"),
                        array($_POST['login'])
                    );

                    // If pseudo match existing user
                    if ($data) {
                        $user = new User($data);

                        $passwordIsValid = $this->checkPassword(
                            htmlspecialchars($_POST['password']),
                            $user->getPassword()
                        );

                        if($passwordIsValid) {
                            $session = $this->_session->getSessionIfDefined($user->getId());

                            // Session exist, just update it
                            if ($session !== false)
                                $this->_session->updateSession($session);
                            // Start a new session and store it in BDD
                            else
                                $this->_session->createSession($user->getId());

                            $this->_twig->render('homepage.html.twig', array());
                        } else
                            $this->errorPassOrLogin();
                    } else
                        $this->errorPassOrLogin();

                } else {
                    $this->_twig->render('login.html.twig', array(
                        'errors' => $errors
                    ));
                }
            }
        } else {
            $this->_twig->render('homepage.html.twig', array());
        }
    }

    /**
     * Handle the registration process of a user
     */
    public function registerAction()
    {
        $errors = [];

        if (isset($_POST['submit'])) {
            if (!isset($_POST['pseudo']) || is_null($_POST['pseudo']))
                $errors['pseudo'] = "Un pseudo doit être fourni.";
            if (!isset($_POST['email']) || is_null($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors['email'] = "Une adresse email valide doit être fournie.";
            if (!isset($_POST['password']) || is_null($_POST['password']))
                $errors['password'] = "Un mot de passe doit être fourni.";

            if (count($errors) === 0) {

                $data = [
                    "pseudo" => htmlspecialchars($_POST['pseudo']),
                    "email" => htmlspecialchars($_POST['email']),
                    "password" => password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT)
                ];

                $user = new User($data);

                if ($this->_manager->insert($user))
                    $this->_twig->render('login.html.twig', array());
                else {
                    $this->_twig->render('register.html.twig', array(
                        'errors' => "An error occured during the registration process"
                    ));
                }
            } else {
                $this->_twig->render('register.html.twig', array(
                    'errors' => $errors
                ));
            }

        } else
            $this->_twig->render('register.html.twig', array());
    }

    public function disconnectAction()
    {
        session_destroy();
    }

    /**
     * Check if password match
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    private function checkPassword($password, $hash)
    {
        if (password_verify($password, $hash))
            return true;
        else
            return false;
    }

    private function errorPassOrLogin() {
        $this->_twig->render('login.html.twig', array(
            'errors' => ['password' => "Login/mot de passe incorrect"]
        ));
    }
}