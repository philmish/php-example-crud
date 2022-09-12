<?php

declare(strict_types=1);

namespace mvcex\api\services\notes\handlers;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\core\Database;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;

final class CreateNote implements MiddlewareHandler
{

    private function insertNote(string $content, int $topicId, Database $db): bool|ApiException
    {
        $args = [$content, $topicId];
        $stmt = 'INSERT INTO Notes (content, topic_id) VALUES (?, ?);';
        try {
            $id = $db->insertOne($stmt, $args);
        } catch (Exception $e) {
            $err = new DBException("Something went wrong creating the note.", null, $e);
            var_dump($e->getMessage());
            return $err;
        }
        if (!$id) {
            return new InvalidInputs("db operation returned false");
        }
        return true;
    }

    public function run(WaresContext $ctx): WaresContext
    {
        $rules = [
            "content" => "required",
            "topic_id" => "required"
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
        $result = $this->insertNote($data['content'], (int)$data['topic_id'], $db);
        if ($result instanceof ApiException) {
            $ctx->setErr($result);
            return $ctx;
        }
        $ctx->setData(["status" => "success"]);
        $ctx->done = true;
        return $ctx;
    }
}
