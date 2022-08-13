<?php declare(strict_types=1);

namespace mvcex\api\routes;

use mvcex\core\Query;
use mvcex\api\lib\DBConnector;

final class DB extends DBConnector {
    public function executeQuery(Query $query): array {
        $res = $query->execute($this->pdo);
        return $res;
    }
}
