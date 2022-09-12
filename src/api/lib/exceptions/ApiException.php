<?php declare(strict_types=1);

namespace mvcex\api\lib\exceptions;

use Exception;
use mvcex\api\lib\APIResponse;
use Throwable;

abstract class ApiException extends Exception {
    public ?Throwable $previous;
    public int $status;
    protected ?array $responsePayload;

    public function __construct(string $msg, int $code, ?array $payload, ?Throwable $prev) {
        $this->message = $msg;
        $this->status = $code; 
        $this->previous = $prev;
        $this->responsePayload = $payload;
        parent::__construct($msg, $code, $prev);
    }

    private function logToErr(): void {
        if(!defined('STDERR')) define('STDERR', fopen('php://stderr', 'wb'));
        if ($this->previous) {
            fwrite(STDERR, $this->previous->getTraceAsString());
        }
        fwrite(STDERR, $this->getTraceAsString() . "\n");
    }

    public function toResponse(): APIResponse {
        $this->logToErr();
        if (!$this->responsePayload) {
            $payload = [$this->getMessage()];
        } else {
            $payload = $this->responsePayload;
            $payload['message'] = $this->getMessage();
        }
        return new APIResponse($this->getCode(),$payload);
    }

    public function __toString(): string {
        return $this->getTraceAsString();
    }
}
