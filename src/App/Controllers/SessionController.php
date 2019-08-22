<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 13:55
 */

namespace App\Controllers;


use App\Managers\SessionManager;
use App\Models\Session;
use Core\Controller\AbstractController;

/**
 * Class SessionController
 * @package App\Controllers
 */
class SessionController extends AbstractController
{
    /**
     * @var SessionManager
     */
    private $_manager;

    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_manager = new SessionManager();
    }

    /**
     * @param $userId
     * @return array
     */
    public function getSessionIfDefined($userId)
    {
        return $this->_manager->search(array("user_id"), array($userId));
    }

    /**
     * @param $userId
     */
    public function createSession($userId)
    {
        $session = new Session(array(
            "token" => $this->generateToken(),
            "creationDate" => date('Y-m-d H:i:s'),
            "userID" => htmlspecialchars($userId)
        ));

        $this->_manager->insert($session);
    }

    /**
     * @param $sessionData
     * @return Session
     */
    public function updateSession($sessionData) {
        $sessionData["token"] = $this->generateToken();
        $sessionData["creation_date"] = date('Y-m-d H:i:s');

        $this->_manager->update($sessionData);

        return new Session($sessionData);
    }

    /**
     * @return string
     *
     * @throws null if an error occurred
     */
    private function generateToken() {
        return bin2hex(random_bytes(50));
    }
}