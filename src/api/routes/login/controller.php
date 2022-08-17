<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\api\lib\Controller;
use mvcex\core\Query;

final class LoginController extends Controller {

    static public function fromEnv(): self
    {
       return new self(DB::fromEnv()); 
    }

    protected function parseRequest(array $decoded): LoginRequest {
        return new LoginRequest($decoded["email"], $decoded["password"]);
    }

    public function execute(): LoginResponse
    {
        $rules = [
            "email" => "required",
            "password" => "required"
        ];
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, true);
        $errors = $this->validate($decoded, $rules);
        if (!empty($errors)) {
            return new LoginResponse(400, $errors);
        }
        $request = $this->parseRequest($decoded);
        $query = Query::fromRequest($request);

        try {
            $res = $this->db->executeQuery($query);
            if (!array_key_exists("name", $res) || (!array_key_exists("password", $res))) {
                return new LoginResponse(403, ["Invalid credentials"]);
            }
            $result = LoginResponse::fromQueryResult($res, $request->getPass());
            return $result;
        } catch (Exception $e) {
            return new LoginResponse(503, [$e->getMessage()]);
        }

    }
}
