<?php declare(strict_types=1);

namespace mvcex\api\lib;

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

final class Required extends Filter {
    private function keyExists(array $data, array $keys, array &$errors)
    {
        foreach($keys as $key) {
            if (!key_exists($key, $data)) {
                $errors[] = "$key is required.";
            }
        }
    }
    public function runFilter(array $data, array &$errors): array
    {
        $this->keyExists($data, $this->args, $errors);
        return $errors;
    }

}
