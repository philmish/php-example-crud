<?php declare(strict_types=1);

namespace mvcex\api\lib\exceptions;

use Throwable;

final class InvalidInputs extends ApiException {

    public function __construct(string $msg = "", ?array $payload = null, ?Throwable $prev = null) {
        parent::__construct($msg, 400, $payload, $prev); 
    }
}
