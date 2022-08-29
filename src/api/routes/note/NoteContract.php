<?php declare(strict_types=1);

namespace mvcex\api\routes;

use Exception;
use mvcex\api\services\notes\NotesController;
use mvcex\core\RouteContract;
use mvcex\api\lib\Command;

final class NoteContract extends RouteContract {
    /**
     * CRUD related to single notes
     */
    protected function GET(): void {
        try {
            $controller = NotesController::fromEnv();
            $response = $controller->execute(Command::FETCH_NOTE);
            $response->send();
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            http_response_code(503);
        }
    }

    protected function POST(): void {
        //TODO implement routes
    }
}

