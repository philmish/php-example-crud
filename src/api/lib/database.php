<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\core\Database;
use mvcex\core\Query;
use PDO;

final class DBConnector implements Database {
    protected PDO $pdo;

    public function __construct(string $dsn, string $user, string $pass)
    {
       $this->pdo = new PDO($dsn, $user, $pass);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function executeQuery(Query $query): array {
        $res = $query->execute($this->pdo);
        return $res;
    }

    static public function fromEnv(): self {
        $dsn = getenv("DB_ADDR");
        $user = getenv("DB_USER");
        $pass = getenv("DB_PASSWORD");
        if (!$dsn || !$user || !$pass) {
            throw new Exception("Missing env vars.");
        } else {
            return new self($dsn, $user, $pass);
        }
    }
}
