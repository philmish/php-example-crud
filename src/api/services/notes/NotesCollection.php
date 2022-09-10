<?php declare(strict_types=1);

namespace mvcex\api\services\notes;

use mvcex\api\lib\APIModelCollection;
use mvcex\api\lib\APIResponse;
use mvcex\api\lib\validation\Validator;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\api\lib\exceptions\NotFound;
use mvcex\core\Database;

final class NotesCollection extends APIModelCollection {
    protected array $items;

    private function __construct(array $items) {
        $this->items = $items;
    }

    public static function Read(Database $db, ?array $requestData): self|ApiException {
        if (!$requestData) {
            return new InvalidInputs("Missing Data");
        }
        $rules = [
            "topic_id" => "required",
        ];
        $validator = new Validator($rules);
        $errors = $validator->run($requestData);
        if ($errors instanceof InvalidInputs) {
            return $errors;
        }
        $stmt = "SELECT id, created, content, topic_id FROM Notes WHERE topic_id = ?";
        $args = [$requestData["topic_id"]];
        $collection = $db->rows($stmt, $args);
        if (!$collection) {
            return new NotFound("No notes found.");
        }
        return new self($collection);
    }

    public function toResponse(): APIResponse {
        return new APIResponse(200, [], $this->items);
    }
}
