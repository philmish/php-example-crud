<?php declare(strict_types=1);

namespace mvcex\core;

use Exception;
use mvcex\core\Response;

interface Model {
    static public function Create(): self|Exception;
    static public function Read(): self|Exception;
    static public function Update(): self|Exception;
    static public function Del(): self|Exception;
    public function toResponse(): Response;
}

