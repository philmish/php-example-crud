<?php declare(strict_types=1);

namespace mvcex\api\services\notes;

use Exception;
use mvcex\api\lib\APIModel;
use mvcex\api\lib\APIResponse;
use mvcex\core\Database;

final class NoteModel extends APIModel {
    private int $id;
    private int $authorId;
    private string $content;
    private string $created;

    public function __constructor(int $id, string $created, string $content, int $authorId) {
        $this->id = $id;
        $this->created = $created;
        $this->content = $content;
        $this->authorId = $authorId; 
    }

    public function getContent(): string {
        return $this->content;
    }

    static public function Read(Database $db, ?array $requestData): self|Exception {
        if (!array_key_exists("id", $requestData) || !array_key_exists("author_id", $requestData)) {
            return new Exception("Invalid input");
        }
        $stmt = "SELECT id, created, content, author_id FROM Notes WHERE id = ? AND author_id = ?";
        $args = [$requestData["id"], $requestData["author_id"]];
        $note = $db->row($stmt, $args);
        if (!$note) {
            return new Exception("Note not found");
        }
        return new self($note["id"], $note["created"], $note["content"], $note["author_id"]);

    }

    public function toResponse(): APIResponse {
        $data = [
            "content" => $this->content,
            "created" => $this->created,
            "id" => $this->id,
        ];
        return new APIResponse(200, [], $data);
    }
}
