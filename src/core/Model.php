<?php declare(strict_types=1);

namespace mvcex\core;

use Exception;
use mvcex\core\Response;

interface Model {
    static public function Create(Database $db, ?array $requestData): self|Exception;
    static public function Read(Database $db, ?array $requestData): self|Exception;
    static public function Update(Database $db, ?array $requestData): self|Exception;
    static public function Del(Database $db, ?array $requestData): self|Exception;
    public function toResponse(): Response;
}

