<?php declare(strict_types=1);

namespace mvcex\api\lib;
use mvcex\api\lib\APIResponse;
use mvcex\core\Model;

abstract class ModelCollection implements Model{
    protected array $items;

    abstract public function Create(): APIResponse;
    abstract public function Read(): APIResponse;
    abstract public function Update(): APIResponse;
    abstract public function Del(): APIResponse;
    abstract public function toJSON(): string|false;
}
