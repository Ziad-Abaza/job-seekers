<?php
// include("./database/config.php");

trait CrudOperationsTrait
{
    private $connection;

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        global $conn; // Import $conn from config.php
        $this->connection = $conn;
    }

    /*
    |--------------------------------------------------------------------------
    | Execute SQL Query Function
    |--------------------------------------------------------------------------
    */
    private function executeQuery($sql)
    {
        $result = $this->connection->query($sql);
        if ($result === false) {
            return json_encode(['error' => $this->connection->error], 400);
        } else {
            return $result;
        }
    }
}
