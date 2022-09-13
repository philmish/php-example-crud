<?php declare(strict_types=1);

namespace mvcex\api\services\links\handlers;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;
use mvcex\core\Database;

final class SaveLink implements MiddlewareHandler {
    
    private function insert(string $label, string $url, int $topicId, Database $db): bool|ApiException {
        $args = [$label, $url, $topicId];
        $stmt = "INSERT INTO Links (label, url, topic_id) VALUES (?, ?, ?);";
        try {
            $result = $db->insertOne($stmt, $args);
        } catch (Exception $e) {
            return new DBException("Something went wrong saving the link.", null, $e);
        }
        if (!is_string($result)) {
            return new InvalidInputs("Failed to insert link.");
        }
        return true;
    }

    public function run(WaresContext $ctx): WaresContext {
        $rules = [
            "label" => "required",
            "url" => "required",
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
        $result = $this->insert($data['label'], $data['url'], (int)$data['topic_id'], $db);
        if ($result instanceof ApiException) {
            $ctx->setErr($result);
            return $ctx;
        }
        $ctx->setData(["status" => "success"]);
        $ctx->done = true;
        return $ctx;
    }
}

