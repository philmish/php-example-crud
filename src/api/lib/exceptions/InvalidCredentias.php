<?php declare(strict_types=1);

namespace mvcex\api\lib\exceptions;

use Throwable;

final class InvalidCredentials extends ApiException {

    public function __construct(string $msg = "", ?array $payload = null, ?Throwable $prev = null) {
        parent::__construct($msg, 401, $payload, $prev); 
    }
}
