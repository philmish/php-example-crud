<?php declare(strict_types=1);

namespace mvcex\api\services\links\handlers;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\NotFound;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;

final class FetchTopicLinks implements MiddlewareHandler {
    
    private function fetchLinks(int $topicId): array|ApiException {
        $args = [$topicId];
        $stmt = "SELECT * FROM Links WHERE topic_id=?;";
        try {
            $notes = $db->row($stmt, $args);
        } catch (Exception $e) {
            return new DBException(
                "Something went wrong fetching links for topic " . (string)$topicId,
                null,
                $e
            );
        }
        if (!is_array($notes)) {
            return new NotFound("No notes found");
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
        $notes = $this->fetchLinks($ctx->getData()['topic_id'], $db);
        if ($notes instanceof ApiException) {
            $ctx->setErr($notes);
            return $ctx;
        }
        $ctx->setData($notes);
        $ctx->done = true;
        return $ctx;
    }
}


