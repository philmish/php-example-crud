<?php declare(strict_types=1);

namespace mvcex\api\lib\validation;

final class IsArray extends Filter {

    private function keyIsArray(array $data, array $keys, array &$errors)
    {
        foreach($keys as $key) {
            if (!array_key_exists($key, $data) || !is_array($data[$key])) {
                $errors[] = "$key must be an array.";
            }
        }
    }
    public function runFilter(array $data, array &$errors): array {
        $this->keyIsArray($data, $this->args, $errors);
        return $errors;
    }
}
