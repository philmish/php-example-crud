<?php declare(strict_types=1);

namespace mvcex\api\lib\handlers;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;

final class GetHandler implements MiddlewareHandler {

    public function run(WaresContext $ctx): WaresContext {
        $ctx->addData($_GET);
        return $ctx;
    }
}


