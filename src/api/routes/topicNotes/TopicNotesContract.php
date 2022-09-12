<?php declare(strict_types=1);

namespace mvcex\api\routes;

use mvcex\api\lib\Command;
use mvcex\api\services\notes\NotesController;
use mvcex\core\RouteContract;

final class TopicNotesContract extends RouteContract {
    
    protected function GET(): void {
        $controller = NotesController::fromEnv();
        $result = $controller->execute(Command::FETCH_NOTES);
        $result->send();
    }
}

