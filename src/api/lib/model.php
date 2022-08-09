<?php declare(strict_types=1);

namespace mvcex\api\lib;

abstract class BaseModel {
    abstract public function toArray(): array;
    abstract static public function fromArray(): self;
}

abstract class BaseCollection extends BaseModel {
    protected array $items;
}
