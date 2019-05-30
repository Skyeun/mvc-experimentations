<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 29/01/19
 * Time: 13:40
 */

namespace App\Models;


use Core\Model;

/**
 * Class Session
 * @package App\Models
 */
class Session extends Model
{
    /**
     * @var string
     */
    private $_token;

    /**
     * @var \DateTime
     */
    private $_creationDate;

    /**
     * @var integer
     */
    private $_userID;

    /**
     * Session constructor.
     * @param array $data
     */
    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * @return int
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * @param int $token
     */
    public function setToken($token)
    {
        $this->_token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->_creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->_creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * @param int $userID
     */
    public function setUserID($userID)
    {
        $this->_userID = $userID;
    }
}