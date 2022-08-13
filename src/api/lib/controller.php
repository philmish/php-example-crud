<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\APIResponse;
use mvcex\core\Request;

abstract class Controller {
    protected DBConnector $db;

    private function __construct(DBConnector $db) {
        $this->db = $db;
    }

    static public function fromEnv():self {
        return new self(DBConnector::fromEnv());
    }

    abstract protected function parseRequest(): Request;
    abstract public function execute(): APIResponse;
}
