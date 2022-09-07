<?php declare(strict_types=1);

namespace mvcex\api\services\auth;

use Exception;
use mvcex\api\lib\APIModel;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\core\Database;

final class LoginModel extends APIModel {
    private string $password;
    private string $hash;

    private function __construct(string $email, string $password, string $hash) {
        $this->email = $email;
        $this->password = $password;
        $this->hash = $hash;
    }

    static public function Read(Database $db, ?array $data): self|ApiException {
        if (!array_key_exists("password", $data) || !array_key_exists("email", $data)) {
            return new Exception("Can't parse provided data.");
        }
        $stmt = "SELECT password FROM Users WHERE email = ?";
        try {
            $user = $db->row($stmt, [$data["email"]]);
            if (!$user) {
                return new InvalidInputs("Invalid credentials");
            }
        } catch (Exception $e) {
            return new DBException("Something went wrong while logging in.", null, $e);
        }
        return new self($data['email'], $data['password'], $user['password']);
    }

    public function toResponse(): APIResponse {
        if (!password_verify($this->password, $this->hash)) {
            return new APIResponse(403, ["Wrong Creds"]);
        }
        return new APIResponse(200, [], ["status" => "success"]);
    }
}
