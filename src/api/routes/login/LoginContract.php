<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\core\RouteContract;
use mvcex\api\services\LoginController;

final class LoginContract extends RouteContract {
    /**
     * Route contract handling authetication
     */
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
