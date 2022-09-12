<?php declare(strict_types=1);

namespace mvcex\api\services\auth;

use mvcex\api\lib\APIController;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\Command;
use mvcex\api\lib\DBConnector;
use mvcex\api\lib\handlers\PostHandler;
use mvcex\api\lib\middleware\WaresChain;
use mvcex\api\services\auth\handlers\LoginHandler;

final class AuthController extends APIController {

    private function parseLogin(): APIResponse {
        $handlers = [new PostHandler(), new LoginHandler()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $response = $chain->runChain();
        return $response;
    }

    public static function fromEnv(): self {
        return new self(DBConnector::fromEnv());
    }

    public function execute(?Command $cmd): APIResponse {
        $result = match ($cmd) {
            Command::LOGIN =>  $this->parseLogin(),
            default => new APIResponse(400, ["Unknown command"]),
        };
        return $result;
    }
}
