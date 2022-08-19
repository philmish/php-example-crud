<?php declare(strict_types=1);

namespace mvcex\api\lib\validation;

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
