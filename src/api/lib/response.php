<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\core\Response;
use mvcex\core\Model;

abstract class APIResponse implements Response {
    /**
     * Serializes and sends response data.
     * TODO: remove array as type from data after refactor
     *
     * @param int $status HTTP statuscode send with the response  
     * @param array<string> $errors  Errors encountered while executing previous operations
     * @param Model|ModelCollection|array|false $data Requested Data
     */
    protected int $status;
    protected array $errors;
    protected Model|ModelCollection|array|false $data;

    public function __construct(int $status, array $errors = [], Model|ModelCollection|array|false $data = false)
    {
        $this->status = $status;
        $this->errors = $errors;
        $this->data = $data;
        
    }

    public function toJSON(): string
    {
        if ($this->data && !is_array($this->data)) {
            return json_encode($this->data->toArray());
        } else if($this->data && is_array($this->data)) {
            return json_encode($this->data);
        } else {
            return json_encode($this->errors);
        }
    }

    public function sendStatus(): void
    {
        http_response_code($this->status);
    }
}
