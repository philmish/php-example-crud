<?php declare(strict_types=1);

namespace mvcex\api\routes;

use mvcex\api\lib\Command;
use mvcex\api\services\links\LinksController;
use mvcex\core\RouteContract;

final class LinkRoute extends RouteContract {
    
    protected function GET(): void {
        $controller = LinksController::fromEnv();
        $result = $controller->execute(Command::FETCH_LINK);
        $result->send();
    }

    protected function POST(): void {
        $controller = LinksController::fromEnv();
        $result = $controller->execute(Command::SAVE_LINK);
        $result->send();
    }
}


