<?php
class Databaseconnection
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->connection) {
            die("Failed to connect: " . mysqli_connect_error());
        }
    }
    public function getConnection()
    {
        return $this->connection;
    }
}
?>
