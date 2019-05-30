<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 14/12/18
 * Time: 20:26
 */

namespace App\Managers;


use App\Models\User;
use Core\Database;
use Core\ManagerInterface;

/**
 * Class UserManager
 * @package App\Managers
 */
class UserManager implements ManagerInterface
{
    /**
     * @var Database
     */
    private $_bdd;

    /**
     * UserManager constructor.
     */
    public function __construct()
    {
        $this->_bdd = Database::getInstance();
    }

    /**
     * @param integer $id
     * @return User
     */
    public function findById($id)
    {
        $data = $this->_bdd->query("SELECT * FROM user WHERE id = " . htmlspecialchars($id));

        return new User($data);
    }

    /**
     * @param array $criteria
     * @param array $parameters
     * @return array
     */
    public function search($criteria, $parameters)
    {
        $sql = "SELECT * FROM user WHERE";

        for ($i = 0; $i < sizeof($criteria); $i++) {
            if ($i === 0)
                $sql = $sql." $criteria[$i] = '".htmlspecialchars($parameters[$i])."'";
            else
                $sql = $sql."AND WHERE $criteria[$i] = '".htmlspecialchars($parameters[$i])."'";
        }

        return $this->_bdd->query($sql);
    }


    /**
     * @param object $user
     * @return array|bool
     */
    public function insert($user)
    {
        $query = "INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)";

        return $this->_bdd->execute($query, array(
            $user->getPseudo(),
            $user->getEmail(),
            $user->getPassword()
        ));
    }

    /**
     * @param object $user
     * @return array|bool
     */
    public function update($user)
    {
        $query = "UPDATE user SET pseudo = ?, email = ?, password = ? WHERE id = ?";

        return $this->_bdd->execute($query, array(
            $user->getPseudo(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getId()
        ));
    }

    /**
     * @param object $user
     * @return bool
     */
    public function delete($user)
    {
        $status = $this->_bdd->exec("DELETE FROM user WHERE id = $user->getId()");

        return $status || false;
    }
}