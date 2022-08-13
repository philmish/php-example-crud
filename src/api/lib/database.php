<?php declare(strict_types=1);

namespace mvcex\api\lib;

use Exception;
use mvcex\core\Database;
use mvcex\core\Query;
use PDO;

abstract class DBConnector implements Database {
    protected PDO $pdo;

    public function __construct(string $dsn, string $user, string $pass)
    {
       $this->pdo = new PDO($dsn, $user, $pass);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    abstract public function executeQuery(Query $query): APIResponse|array;
    abstract static public function fromEnv(): self;
}
