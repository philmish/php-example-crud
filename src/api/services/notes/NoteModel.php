<?php declare(strict_types=1);

namespace mvcex\api\services\notes;

use Exception;
use mvcex\api\lib\APIModel;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\validation\Validator;
use mvcex\core\Database;

final class NoteModel extends APIModel {
    private int $id;
    private int $topic_id;
    private string $content;
    private string $created;

    public function __constructor(int $id, string $created, string $content, int $topicId) {
        $this->id = $id;
        $this->created = $created;
        $this->content = $content;
        $this->topic_id = $topicId; 
    }

    public function getContent(): string {
        return $this->content;
    }

    static public function Create(Database $db, ?array $requestData): self|Exception {
        $rules = [
            "content" => "required",
            "topic_id" => "required"
        ];
        $validator = new Validator($rules);
        $errors = $validator->run($requestData);
        if (!empty($errors)) {
            return new Exception("Invalid input");
        }
        $stmt = "INSERT (content, topic_id) INTO Notes VALUES (:content, :topic_id);";
        $inserted = $db->insertOne($stmt, $requestData);
        if (!$inserted) {
            return new Exception("Failed to connect to database");
        }
        $stmt = "SELECT * FROM Notes WHERE id=?";
        $args = [$inserted];
        $note = $db->row($stmt, $args);
        if (!$note) {
            return new Exception("Failed to fetch note after creation");
        }
        return new self(
            (int)$note['id'],
            $note['created'],
            $note['content'],
            (int)$note['topic_id']
        );
    }

    static public function Read(Database $db, ?array $requestData): self|Exception {
        if (!array_key_exists("id", $requestData) || !array_key_exists("topic_id", $requestData)) {
            return new Exception("Invalid input");
        }
        $stmt = "SELECT id, created, content, topic_id FROM Notes WHERE id = ? AND topic_id = ?";
        $args = [$requestData["id"], $requestData["topic_id"]];
        $note = $db->row($stmt, $args);
        if (!$note) {
            return new Exception("Note not found");
        }
        return new self($note["id"], $note["created"], $note["content"], $note["topic_id"]);

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
