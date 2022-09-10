<?php declare(strict_types=1);

namespace mvcex\api\lib\middleware;

interface MiddlewareHandler {
    public function run(WaresContext $ctx): WaresContext;
}
