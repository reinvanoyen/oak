<?php

namespace Oak\Database\Connection;

/**
 * Base connection class providing all necessary methods every connection needs.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class Connection
{
    /**
     * @var mixed $pdo
     */
    private $pdo;

    /**
     * Get the PDO connection
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * Set the PDO connection
     * @param $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Disconnect the PDO connection
     */
    public function disconnect()
    {
        $this->setPdo(null);
    }

    /**
     * @param string $query
     * @return false|\PDOStatement
     */
    public function query(string $query)
    {
        return $this->getPdo()->query($query);
    }
}