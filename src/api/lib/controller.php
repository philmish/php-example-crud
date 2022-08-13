<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\APIResponse;
use mvcex\core\Request;

abstract class Controller {
    protected DBConnector $db;

    protected function __construct(DBConnector $db) {
        $this->db = $db;
    }

    abstract static public function fromEnv():self;
    abstract protected function parseRequest(): Request;
    abstract public function execute(): APIResponse;
}
