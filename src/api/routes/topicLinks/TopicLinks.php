<?php declare(strict_types=1);

namespace mvcex\api\routes;

use mvcex\api\lib\Command;
use mvcex\api\services\links\LinksController;
use mvcex\core\RouteContract;

final class TopicLinks extends RouteContract {
    
    protected function GET(): void {
        $controller = LinksController::fromEnv();
        $result = $controller->execute(Command::FETCH_TOPIC_LINKS);
        $result->send();
    }
}


