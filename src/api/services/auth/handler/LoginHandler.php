<?php

declare(strict_types=1);

namespace mvcex\api\services\auth\handlers;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\InvalidCredentials;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;
use mvcex\core\Database;

final class LoginHandler implements MiddlewareHandler
{

    private function getHash(string $email, Database $db): string|InvalidCredentials|DBException
    {
        $stmt = "SELECT password FROM Users WHERE email = ?";
        try {
            $user = $db->row($stmt, [$email]);
            if (!$user) {
                return new InvalidCredentials("Invalid Credentials");
            }
        } catch (Exception $e) {
            return new DBException("Something went wrong while logging in.", null, $e);
        }
        return $user['password'];
    }

    public function run(WaresContext $ctx): WaresContext
    {
        $rules = [
            "email" => "required",
            "password" => "required"
        ];
        $ctx->validateData($rules);
        if ($ctx->done) {
         return $ctx;
        }
        $db = $ctx->getDB();
        if ($ctx->done) { 
            return $ctx;
        } 
        $hash = $this->getHash($ctx->getData()["email"], $db);
        if ($hash instanceof ApiException) {
            $ctx->setErr($hash);
            return $ctx;
        }
        if (!password_verify($ctx->getData()["password"], $hash)) {
            $err = new InvalidCredentials("Invalid Credentials");
            $ctx->setErr($err);
            return $ctx;
        }
        $ctx->setData(["status" => "success"]);
        return $ctx;
    }
}
