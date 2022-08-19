<?php declare(strict_types=1);

namespace mvcex\api\lib;
use mvcex\core\Model;
use mvcex\core\Database;
use mvcex\api\lib\APIResponse;


abstract class APIModelCollection implements Model {
    protected Database $db;

    protected function __construct(Database $db)
    {
        $this->db = $db;
    }
    abstract public function Create(): APIResponse;
    abstract public function Read(): APIResponse;
    abstract public function Update(): APIResponse;
    abstract public function Del(): APIResponse;
    abstract public function toJSON(): string|false;
}
