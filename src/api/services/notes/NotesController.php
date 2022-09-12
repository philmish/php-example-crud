<?php declare(strict_types=1);

namespace mvcex\api\services\notes;

use mvcex\api\lib\Command;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\DBConnector;
use mvcex\api\lib\APIController;
use mvcex\api\lib\handlers\GetHandler;
use mvcex\api\lib\handlers\PostHandler;
use mvcex\api\lib\middleware\WaresChain;
use mvcex\api\services\notes\handlers\FetchNote;
use mvcex\api\services\notes\handlers\CreateNote;
use mvcex\api\services\notes\handlers\FetchTopicNotes;

final class NotesController extends APIController {

    private function getNote(): APIResponse {
        $handlers = [new GetHandler(), new FetchNote()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $result = $chain->runChain();
        return $result;
    }

    private function createNote(): APIResponse {
        $handlers = [new PostHandler(), new CreateNote()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $result = $chain->runChain();
        return $result;
    }

    private function getNotes(): APIResponse {
        $handlers = [new GetHandler(), new FetchTopicNotes()];
        $chain = new WaresChain(null, $handlers, $this->db);
        $result = $chain->runChain();
        return $result;
    }

    static public function fromEnv(): APIController {
        return new self(DBConnector::fromEnv());
    }

    public function execute(?Command $cmd): APIResponse {
        $result = match ($cmd) {
            Command::FETCH_NOTES => $this->getNotes(),
            Command::FETCH_NOTE => $this->getNote(),
            Command::CREATE_NOTE => $this->createNote(),
            default => new APIResponse(400, ["Unknown command"]),
        };
        return $result;
    }
}
