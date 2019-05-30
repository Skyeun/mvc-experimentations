<?php

namespace App\Models;

use Core\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model {

    /**
     * @var integer
     */
    private $_id;
    /**
     * @var string
     */
    private $_pseudo;
    /**
     * @var string
     */
    private $_email;
    /**
     * @var string
     */
    private $_password;

    /**
     * User constructor.
     * @param array $data
     */
    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $id = (int)$id;

        if ($id > 0)
            $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->_pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo($pseudo)
    {
        if (is_string($pseudo))
            $this->_pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        if (is_string($password))
            $this->_password = $password;
    }
}