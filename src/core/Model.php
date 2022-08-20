<?php declare(strict_types=1);

namespace mvcex\core;

use Exception;
use mvcex\core\Response;

interface Model {
    static public function Create(Database $db): self|Exception;
    static public function Read(Database $db): self|Exception;
    static public function Update(Database $db): self|Exception;
    static public function Del(Database $db): self|Exception;
    public function toResponse(): Response;
}

