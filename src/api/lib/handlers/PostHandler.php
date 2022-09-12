<?php declare(strict_types=1);

namespace mvcex\api\lib\handlers;

use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;

final class PostHandler implements MiddlewareHandler {
    
    public function run(WaresContext $ctx): WaresContext {
        $data = json_decode(file_get_contents('php://input'), true);
        $ctx->addData($data);
        return $ctx;
    }
}


