<?php declare(strict_types=1);

namespace mvcex\api\services\notes;

use Exception;
use mvcex\api\lib\APIController;
use mvcex\api\lib\Command;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\exceptions\ApiException;

final class NotesController extends APIController {

    private function getNote(): APIResponse {
        $note = NoteModel::Read($this->db, $_GET);
        return 
    }

    private function getNotes(): APIResponse {
        $notes = NotesCollection::Read($this->db, $_GET);
        if ($notes instanceof Exception) {
            return new APIResponse(400, [$notes->getMessage()]);
        }
        return $notes;
    }

    public function execute(?Command $cmd): APIResponse {
        $result = match ($cmd) {
            Command::FETCH_NOTES => $this->getNotes(),
            Command::FETCH_NOTE => $this->getNote(),
            default => new APIResponse(400, ["Unknown command"]),
        };
        return $result;
    }
}
