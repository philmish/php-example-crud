<?php declare(strict_types=1);

namespace mvcex\api\routes;
use mvcex\api\lib\RouteContract;

final class LoginContract extends RouteContract {
    protected function POST(): void {
        echo("Login Endpoint");
    }
}
