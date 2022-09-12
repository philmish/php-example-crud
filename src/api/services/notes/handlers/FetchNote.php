<?php declare(strict_types=1);

namespace mvcex\api\services\notes\handlers;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;
use mvcex\core\Database;

final class FetchNote implements MiddlewareHandler {
    
    private function getNote(int $id, int $topic, Database $db): array|ApiException {
        $stmt = "SELECT id, created, content, topic_id FROM Notes WHERE id = ? AND topic_id = ?";
        $args = [$id, $topic];
        $result = $db->row($stmt, $args);
        if ($result === false) {
            return new DBException("Something went wrong fetching the note", null, new Exception("No DB connection"));
        }
        return $result;
    }

    public function run(WaresContext $ctx): WaresContext {
        $rules = [
            "id" => "required",
            "topic_id" => "required"
        ];
        $ctx->validateData($rules);
        if ($ctx->done) {
            return $ctx;
        }
        $db = $ctx->getDB();
        if (!$db) {
            $err = new DBException("No DB connection");
            $ctx->setErr($err);
            return $ctx;
        }
        $data = $ctx->getData();
        $result = $this->getNote($data['id'], $data['topic_id'], $db);
        if ($result instanceof DBException) {
            $ctx->setErr($result);
            return $ctx;
        }
        $ctx->setData($result);
        return $ctx;
    }
}
