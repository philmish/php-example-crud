<?php declare(strict_types=1);

namespace mvcex\api\lib;

use Exception;
use mvcex\core\Database;
use mvcex\core\Model;

abstract class APIModel implements Model {
    protected Database $db;

    protected function __construct(Database $db)
    {
        $this->db = $db;
    }
    static public function Create(): self|Exception {
        return new Exception("Not implemented");
    }
    static public function Read(): self|Exception {
        return new Exception("Not implemented");
    }
    static public function Update(): self|Exception {
        return new Exception("Not implemented");
    }
    static public function Del(): self|Exception {
        return new Exception("Not implemented");
    }
    abstract public function toResponse(): APIResponse;
}
