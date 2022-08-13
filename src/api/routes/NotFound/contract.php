<?php declare(strict_types=1);

namespace mvcex\api\routes;

use mvcex\api\lib\RouteContract;

final class NotFoundContract extends RouteContract {

    protected function GET(): void {
        http_response_code(404);
    }

    protected function POST(): void {
        http_response_code(404);
    }

    protected function PUT(): void {
        http_response_code(404);
    }

    protected function DEL(): void {
        http_response_code(404);
    }
}
