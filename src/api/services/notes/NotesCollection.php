<?php declare(strict_types=1);

namespace mvcex\api\services\notes;

use Exception;
use mvcex\api\lib\APIModelCollection;
use mvcex\api\lib\APIResponse;
use mvcex\core\Database;

final class NotesCollection extends APIModelCollection {
    protected array $items;

    private function __construct(array $items) {
        $this->items = $items;
    }

    public static function Read(Database $db, ?array $requestData): self| Exception {
        if (!is_array($requestData) || !array_key_exists("topic_id", $requestData)) {
            return new Exception("Invalid input");
        }
        $stmt = "SELECT id, created, content, topic_id FROM Notes WHERE topic_id = ?";
        $args = [$requestData["topic_id"]];
        $collection = $db->rows($stmt, $args);
        if (!$collection) {
            return new Exception("Notess not found");
        }
        return new self($collection);
    }

    public function toResponse(): APIResponse {
       return new APIResponse(503, ["Not implemented"]);
    }
}
