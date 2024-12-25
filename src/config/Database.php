<?php 
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "petsmart";

        $this->connection = new \mysqli($host, $username, $password, $dbname);

        if ($this->connection->connect_error) {
            throw new \Exception("Connection Failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>