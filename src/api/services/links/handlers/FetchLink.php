<?php declare(strict_types=1);

namespace mvcex\api\services\links\handler;

use Exception;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\DBException;
use mvcex\api\lib\exceptions\NotFound;
use mvcex\api\lib\middleware\MiddlewareHandler;
use mvcex\api\lib\middleware\WaresContext;
use mvcex\core\Database;

final class FetchLink implements MiddlewareHandler {

    private function getLink(int $id, Database $db): array|ApiException {
        $args = [(int)$id];
        $stmt = "SELECT * FROM Links WHERE id = ?;";
        try {
            $note = $db->row($stmt, $args);
        } catch (Exception $e) {
            return new DBException("Something went wrong fetching the link.", null, $e);
        }
        if (!is_array($note)) {
            return new NotFound("Note not found");;
        }
        return $note;
    }

    public function run(WaresContext $ctx): WaresContext {
        $rules = [
            "id" => "required",
        ];
        $ctx->validateData($rules);
        if ($ctx->done) {
            return $ctx;
        }
        $db = $ctx->getDB();
        if ($ctx->done) {
            return $ctx;
        }
        $note = $this->getLink((int)$ctx->getData()['id'], $db);
        if ($note instanceof ApiException) {
            $ctx->setErr($note);
            return $ctx;
        }
        $ctx->setData($note);
        $ctx->done = true;
        return $ctx;
    }
}
