<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\core\Database;
use mvcex\core\Model;

abstract class APIModel implements Model {
    protected Database $db;
    abstract public function Create(): APIResponse;
    abstract public function Read(): APIResponse;
    abstract public function Update(): APIResponse;
    abstract public function Del(): APIResponse;
    abstract public function toJSON(): string|false;
}
