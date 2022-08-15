<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\APIResponse;
use mvcex\core\Request;

abstract class Controller {
    protected DBConnector $db;

    protected function __construct(DBConnector $db) {
        $this->db = $db;
    }

    protected function validate(array $data, array $rules): array {
        $validator = new Validator($rules);
        $result = $validator->run($data);
        return $result;
    }

    abstract static public function fromEnv():self;
    abstract protected function parseRequest(array $decoded): Request;
    abstract public function execute(): APIResponse;
}
