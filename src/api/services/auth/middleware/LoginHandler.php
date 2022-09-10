<?php declare(strict_types=1);

namespace mvcex\api\services\auth\middleware;

use Exception;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;
use mvcex\core\Database;

final class LoginHandler implements MiddlewareHandler {

    private function getHash(string $email, Database $db): string|false|DBException {
        $stmt = "SELECT password FROM Users WHERE email = ?";
        try {
            $user = $db->row($stmt, [$email]);
            if (!$user) {
                return false;
            }
        } catch (Exception $e) {
            return new DBException("Something went wrong while logging in.", null, $e);
        }
        return $user['password'];
    }

    public function run(WaresContext $ctx): WaresContext {
        $db = $ctx->getDB();
        if (!$db) {
            $ctx->setErr(new DBException("Something went wrong loging in."));
            $ctx->done = true;
            return $ctx;
        } 
        $data = $ctx->getData();
        if (!$data) {
            $ctx->done = true;
            $ctx->setErr(new InvalidInputs("Missing email and password"));
            return $ctx;
        } else if (!array_key_exists("email", $data)) {
            $ctx->done = true;
            $ctx->setErr(new InvalidInputs("Missing email"));
            return $ctx;
        } 
    }
}
