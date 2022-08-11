<?php declare(strict_types=1);

namespace mvcex;
require_once('src/autoload.php');

use Exception;
use mvcex\api\routes\LoginContract;

$uri = rtrim($_SERVER['REQUEST_URI'], '/');
$path = explode('?', $uri)[0];

try {
    $route = match ($uri) {
    '/login' => new LoginContract()
}; $route->serve();
} catch (Exception $e) {
    echo $e->getMessage();
}
