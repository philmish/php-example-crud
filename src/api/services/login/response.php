<?php declare(strict_types=1);

namespace mvcex\api\routes;
use mvcex\api\lib\APIResponse;

final class LoginResponse extends APIResponse {

    public static function fromQueryResult(array $result, ?string ...$args): self {
        $auth = password_verify($args[0], $result["password"]);
        if (!$auth) {
            return new self(403, ['Invalid credentials']);
        }
        return new self(200, [], ['data' => 'success']);
    }
}
