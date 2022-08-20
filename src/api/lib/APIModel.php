<?php declare(strict_types=1);

namespace mvcex\api\lib;

use Exception;
use mvcex\core\Database;
use mvcex\core\Model;

abstract class APIModel implements Model {
    static public function Create(Database $db): self|Exception {
        return new Exception("Not implemented");
    }

    static public function Read(Database $db): self|Exception {
        return new Exception("Not implemented");
    }

    static public function Update(Database $db): self|Exception {
        return new Exception("Not implemented");
    }

    static public function Del(Database $db): self|Exception {
        return new Exception("Not implemented");
    }

    abstract public function toResponse(): APIResponse;
}
