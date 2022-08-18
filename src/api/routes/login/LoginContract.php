<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\api\lib\RouteContract;
use mvcex\api\services\LoginController;


final class LoginContract extends RouteContract {
    protected function POST(): void {
        try {
            $controller = LoginController::fromEnv();
            $result = $controller->execute();
            echo $result->toJSON();
            $result->sendStatus();
        } catch( Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            http_response_code(503);
        }
    }
}
