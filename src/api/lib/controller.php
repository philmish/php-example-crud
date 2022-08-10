<?php declare(strict_types=1);

namespace mvcex\api\lib;

use APIResponse;
use mvcex\core\Request;

abstract class Controller {
    protected DBConnector $db;

    abstract protected function parseRequest(): Request;
    abstract public function execute(): APIResponse;
}
