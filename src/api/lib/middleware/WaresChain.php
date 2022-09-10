<?php declare(strict_types=1);

namespace mvcex\api\lib\middleware;

use mvcex\api\lib\APIResponse;
use mvcex\core\Database;

final class WaresChain {
    private array $handlers;
    private ?array $data;
    private ?Database $db;

    public function __construct(array $data = null, array $handlers = [], ?Database $db = null) {
        $this->handlers = $handlers;
        $this->db = $db; 
        $this->data = $data;
    }

    public function appendWare(MiddlewareHandler $handler): void {
        array_push($this->handlers, $handler);
    }

    private function nextHandler(WaresContext $ctx): WaresContext {
        if (count($this->handlers) > 0) {
            $handler = $this->handlers[0];
            $this->handlers = array_splice($this->handlers, 1);
            return $handler->run($ctx);
        }
        $ctx->done = true;
        return $ctx;
    }

    public function runChain(): APIResponse {
        $ctx = new WaresContext($this->data);
        if ($this->db) {
            $ctx->injectDB($this->db);
        }
        do {
            $ctx = $this->nextHandler($ctx);
        } while (count($this->handlers) > 0 && !$ctx->Done);
        return $ctx->toResponse();
    }
}
