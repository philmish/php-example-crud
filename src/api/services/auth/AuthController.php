<?php declare(strict_types=1);

namespace mvcex\api\services\auth;

use Exception;
use mvcex\api\lib\APIController;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\Command;
use mvcex\api\lib\DBConnector;
use mvcex\api\lib\exceptions\ApiException;

final class AuthController extends APIController {

    private function parseLogin(): APIResponse {
        $rules = [
            "email" => "required",
            "password" => "required"
        ];
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, true);
        $errors = $this->validate($decoded, $rules);
        if ($errors instanceof ApiException) {
            return $errors->toResponse();
        }
        $model = LoginModel::Read($this->db, $decoded);
        return $model->toResponse();
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
