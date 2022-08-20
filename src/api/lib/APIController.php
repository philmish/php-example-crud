<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\validation\Validator;
use mvcex\api\lib\APIResponse;
use mvcex\core\Database;

abstract class APIController {
    protected Database $db;

    protected function __construct(Database $db) {
        $this->db = $db;
    }
    /**
     * Validate a list of rules on an array of data.
     *
     * @param array<string, mixed>|array<int, mixed>|null $data Data to run the validator on 
     * @param array<string, string> $rules Rules to validate
     * @return array<string> $result A list of encountered errors
     */
    protected function validate(?array $data, array $rules): array {
        if (!$data) {
            return ["Missing input"];
        }
        $validator = new Validator($rules);
        $result = $validator->run($data);
        return $result;
    }

    abstract static public function fromEnv():self;
    abstract public function execute(): APIResponse;
}
