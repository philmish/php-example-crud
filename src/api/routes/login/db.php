<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\core\Query;
use mvcex\api\lib\DBConnector;

final class DB extends DBConnector {
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
