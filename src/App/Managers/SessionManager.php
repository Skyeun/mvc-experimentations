<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 13:56
 */

namespace App\Managers;

use App\Models\Session;
use Core\Database;
use Core\ManagerInterface;

/**
 * Class SessionManager
 * @package App\Managers
 */
class SessionManager implements ManagerInterface
{
    /**
     * @var Database
     */
    private $_bdd;

    /**
     * SessionManager constructor.
     */
    public function __construct()
    {
        $this->_bdd = Database::getInstance();
    }

    /**
     * @param int $id
     * @return Session|mixed
     */
    public function findById($id)
    {
        $data = $this->_bdd->query("SELECT * FROM sessions WHERE id = " . htmlspecialchars($id));

        return new Session($data);
    }

    /**
     * @param array $criteria
     * @param array $parameters
     * @return array
     */
    public function search($criteria, $parameters)
    {
        $sql = "SELECT * FROM sessions WHERE";

        for ($i = 0; $i < sizeof($criteria); $i++) {
            if ($i === 0)
                $sql = $sql." $criteria[$i] = '".htmlspecialchars($parameters[$i])."'";
            else
                $sql = $sql."AND WHERE $criteria[$i] = '".htmlspecialchars($parameters[$i])."'";
        }

        return $this->_bdd->query($sql);
    }

    /**
     * @param object $session
     * @return array|bool
     */
    public function insert($session)
    {
        $query = "INSERT INTO sessions (token, creation_date, user_id) VALUES (?, ?, ?)";

        return $this->_bdd->execute($query, array(
            $session->getToken(),
            $session->getCreationDate(),
            $session->getUserID()
        ));
    }

    /**
     * @param object $session
     * @return array|bool
     */
    public function update($session)
    {
        $query = "UPDATE sessions SET token = ?, creation_date = ?, user_id = ?";

        return $this->_bdd->execute($query, array(
            $session['token'],
            $session['creation_date'],
            $session['user_id']
        ));
    }

    /**
     * @param object $session
     * @return bool
     */
    public function delete($session)
    {
        $status = $this->_bdd->exec("DELETE FROM sessions WHERE token = $session->getToken()");

        return $status || false;
    }
}