<?php declare(strict_types=1);

require_once('src/autoload.php');

use Exception;

$uri = rtrim($_SERVER['REQUEST_URI'], '/');
$path = explode('?', $uri)[0];

try {
    $route = match ($uri) {
    '/' => http_response_code(404)
};
} catch (Exception $e) {
    echo $e->getMessage();
}
