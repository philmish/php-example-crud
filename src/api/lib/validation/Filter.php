<?php declare(strict_types=1);

namespace mvcex\api\lib\validation;

abstract class Filter {
    protected array $errors;
    protected array $args;

    public function __construct(array $args = [])
    {
        $this->args = $args;
    }

    public function errs(): array {
        return $this->errors;
    }

    abstract public function runFilter(array $data, array &$errors): array;
}
