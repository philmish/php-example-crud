<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\core\Response;

final class APIResponse implements Response {
    /**
     * Serializes and sends response data.
     *
     * @param int $status HTTP statuscode send with the response  
     * @param array<string> $errors  Errors encountered while executing previous operations
     * @param array|false $data Requested Data
     */
    public int $status;
    protected array $errors;
    protected array|false $data;

    public function __construct(int $status, array $errors = [], array|false $data = false) {
        $this->status = $status;
        $this->errors = $errors;
        $this->data = $data;
    }
    
    /**
     *
     * Sends the status code and either the serialized errors or data.
     */
    public function send(): void {
        http_response_code($this->status);
        if (!$this->data) {
            echo json_encode($this->errors);
        } else {
            echo json_encode($this->data);
        }
    }
}
