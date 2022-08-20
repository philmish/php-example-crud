<?php declare(strict_types=1);

namespace mvcex\api\services\auth;

use Exception;
use mvcex\api\lib\APIController;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\Command;
use mvcex\api\lib\DBConnector;

final class AuthController extends APIController {

    static public function fromEnv(): self
    {
       return new self(DBConnector::fromEnv()); 
    }

    protected function parseLogin(): APIResponse {
        $rules = [
            "email" => "required",
            "password" => "required"
        ];
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, true);
        $errors = $this->validate($decoded, $rules);
        if (!empty($errors)) {
            return new APIResponse(400, $errors);
        }
        $model = LoginModel::Read($this->db, $decoded);
        if ($model instanceof Exception) {
            return new APIResponse(503, [$model->getMessage()]);
        }
        return $model->toResponse();
    }

    public function execute(?Command $cmd): APIResponse {
        $result = match ($cmd) {
            Command::LOGIN =>  $this->parseLogin(),
            default => new APIResponse(400, ["Unknown command"]),
        };
        return $result;
    }
}
