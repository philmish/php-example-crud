<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\api\lib\RouteContract;

final class LoginContract extends RouteContract {
    protected function POST(): void {
        try {
            $controller = LoginController::fromEnv();
            $result = $controller->execute();
            echo $result->toJSON();
            $result->sendStatus();
        } catch( Exception ) {
            echo json_encode(["error" => "No DB connection"]);
            http_response_code(503);
        }
    }
}
