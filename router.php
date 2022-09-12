<?php declare(strict_types=1);

namespace mvcex;
require_once('src/autoload.php');

use Exception;
use mvcex\api\routes\LoginContract;
use mvcex\api\routes\NotFoundContract;
use mvcex\api\routes\NoteContract;
use mvcex\api\routes\TopicNotesContract;

$uri = rtrim($_SERVER['REQUEST_URI'], '/');
$path = explode('?', $uri)[0];

try {
    $route = match ($path) {
    '/login' => new LoginContract(),
    '/note' => new NoteContract(),
    '/note/topic' => new TopicNotesContract(),
    default => new NotFoundContract(),
}; $route->serve();
} catch (Exception $e) {
    echo $e->getMessage();
}
