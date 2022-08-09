<?php declare(strict_types=1);

namespace mvcex\api\lib;
use mvcex\core\Database;
use mvcex\core\Query;
use mvcex\core\Response;
use PDO;

abstract class DBConnector implements Database {
    protected PDO $pdo;

    public function __construct(string $dsn, string $user, string $pass): void
    {
       $this->pdo = new PDO($dsn, $user, $pass);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    abstract public function executeQuery(Query $query): Response;
    abstract static public function fromEnv(): self;
}
