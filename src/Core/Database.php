<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/12/18
 * Time: 17:01
 */

namespace Core;
use Dotenv\Dotenv;
use PDO;

/**
 * Class Database
 * @package Core
 */
class Database
{
    /**
     * @var PDO
     */
    private $_db;
    /**
     * @var
     */
    static $_instance;
    private $_dotenv;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        // Load environment variables
        $this->_dotenv = Dotenv::create(realpath('.'));
        $this->_dotenv->load();

        $this->_db =
            new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD'));

        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return Database
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();

        return self::$_instance;
    }

    /**
     * @param string $sql
     * @return array
     */
    public function query($sql)
    {
        $query = $this->_db->query($sql);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array $parameters
     * @return array
     */
    public function execute($sql, $parameters)
    {
        $query = $this->_db->prepare($sql);
        $query->execute($parameters);

        return true;
    }

    /**
     * @param string $sql
     */
    public function exec($sql)
    {
        $this->_db->exec($sql);
    }
}