<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\core\Database;
use PDO;
use Exception;

final class DBConnector implements Database {
    protected PDO $pdo;

    public function __construct(string $dsn, string $user, string $pass)
    {
       $this->pdo = new PDO($dsn, $user, $pass);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::FETCH_ASSOC);
    }

    public function row(string $stmt, ?array $args): array {
        $prep = $this->pdo->prepare($stmt, $args);
        return $prep->fetch();
    }

    public function rows(string $stmt, ?array $args): array {
        $prep = $this->pdo->prepare($stmt, $args);
        return $prep->fetchAll();
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
