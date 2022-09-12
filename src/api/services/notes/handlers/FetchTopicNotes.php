<?php declare(strict_types=1);

namespace mvcex\api\services\notes\handlers;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\NotFound;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;
use mvcex\core\Database;

final class FetchTopicNotes implements MiddlewareHandler {
    
    private function getNotes(int $topicId, Database $db): array|ApiException {
       $args = [$topicId];
       $stmt = "SELECT id, created, content, topic_id FROM Notes WHERE topic_id = ?;";
       try {
           $notes = $db->rows($stmt, $args);
       } catch(Exception $e) {
           return new DBException(
               "Something went wrong fetching topic notes for id " . (string)$topicId,
               null,
               $e
           );
       }
       if (!is_array($notes)) {
           return new NotFound("Could not find notes for topic");
       }
       return $notes;
    }

    public function run(WaresContext $ctx): WaresContext {
        $rules = [
            "topic_id" => "required",
        ];
        $ctx->validateData($rules);
        if ($ctx->done) {
            return $ctx;
        }
        $db = $ctx->getDB();
        if ($ctx->done) {
            return $ctx;
        }
        $data = $ctx->getData();
        $notes = $this->getNotes((int)$data['topic_id'], $db);
        if ($notes instanceof ApiException) {
            $ctx->setErr($notes);
            return $ctx;
        }
        $ctx->setData($notes);
        $ctx->done = true;
        return $ctx;
    }
}


