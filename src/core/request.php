<?php declare(strict_types=1);

namespace mvcex\core;

use Closure;

interface Request {
    public function toQuery(): Closure;
}
