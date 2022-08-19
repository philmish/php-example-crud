<?php declare(strict_types=1);

namespace mvcex\core;

use mvcex\core\Response;

interface Model {
    public function Create(): Response;
    public function Read(): Response;
    public function Update(): Response;
    public function Del(): Response;
    public function toJSON(): string|false;
}

