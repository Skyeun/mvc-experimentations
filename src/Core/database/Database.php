<?php


namespace Core\Database;


use PDO;

class Database
{
    private static $instance;

    private $db;
    private $configs;
    private $debug;

    /**
     * @param array $configs    database configurations
     * @param bool $debug       enable PDO debug mode
     */
    public function __construct(array $configs, bool $debug)
    {
        if (self::$instance instanceof self) {
            throw new \RuntimeException("Database connexion already instantiated");
        }

        $this->configs = $configs;
        $this->debug = $debug;

        // Instantiate bdd connexion
        try {
            $this->db =
                new PDO("mysql:host=". $configs('host') . ";dbname=" . $configs['database'],
                    $configs['user'],
                    $configs['password']);

            $this->db->exec("SET CHARACTER SET utf8mb4");

            if ($debug) {
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
        } catch (\Exception $exception) {
            throw new \PDOException("Could not connect with database. \n" . $exception->getMessage());
        }
    }

    /**
     * Get instance of Database
     *
     * @return Database
     * @throws \RuntimeException when database connexion was never instantiated
     */
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            throw new \RuntimeException("Database connexion was never instantiated");
        }

        return self::$instance;
    }

    /**
     * Execute SQL query with parameters
     *
     * @param string $query
     * @param array $parameters
     * @return bool
     */
    public function query(string $query, array $parameters)
    {
        $query = $this->db->prepare($query);
        return $query->execute($parameters);
    }
}