<?php

namespace Oak\Database\Connection;

use Oak\Contracts\Database\Connection\ConnectionInterface;

/**
 * Class providing connection with a MySQL database.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class MysqlConnection extends Connection implements ConnectionInterface
{
    /**
     * @var string $dsn
     */
    private $dsn;

    /**
     * @var string $user
     */
    private $user;

    /**
     * @var string $password
     */
    private $password;

    /**
     * MysqlConnection constructor.
     * @param string $dsn
     * @param string $user
     * @param string $password
     */
    public function __construct(string $dsn, string $user = '', string $password = '')
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Connect to the MySQL database
     */
    public function connect()
    {
        try {
            $this->setPdo(new \PDO($this->dsn, $this->user, $this->password));
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}