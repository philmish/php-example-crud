<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\core\Model;
use mvcex\core\Database;
use mvcex\api\lib\APIResponse;


abstract class APIModelCollection implements Model {
    protected array $items;

    static public function Create(Database $db, ?array $data): self|ApiException {
        return new InvalidInputs("Not implemented");
    }
    
    static public function Read(Database $db, ?array $data): self|ApiException {
        return new InvalidInputs("Not implemented");
    }

    static public function Update(Database $db, ?array $data): self|ApiException {
        return new InvalidInputs("Not implemented");
    }

    static public function Del(Database $db, ?array $data): self|ApiException {
        return new InvalidInputs("Not implemented");
    }

    abstract public function toResponse(): APIResponse;

}
