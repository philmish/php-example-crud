<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\core\RouteContract;
use mvcex\api\lib\Command;
use mvcex\api\services\auth\AuthController;

final class LoginContract extends RouteContract {
    /**
     * Route contract handling authetication
     */
    protected function POST(): void {
        try {
            $controller = AuthController::fromEnv();
            $response = $controller->execute(Command::LOGIN);
            $response->send();
        } catch( Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            http_response_code(503);
        }
    }
}
