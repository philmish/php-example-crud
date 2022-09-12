<?php declare(strict_types=1);

namespace mvcex\api\routes;

use mvcex\api\services\notes\NotesController;
use mvcex\core\RouteContract;
use mvcex\api\lib\Command;

final class NoteContract extends RouteContract {
    /**
     * CRUD related to single notes
     */
    protected function GET(): void {
        $controller = NotesController::fromEnv();
        $response = $controller->execute(Command::FETCH_NOTE);
        $response->send();
            
    }

    protected function POST(): void {
        $controller = NotesController::fromEnv();
        $response = $controller->execute(Command::CREATE_NOTE);
        $response->send();
    }
}

