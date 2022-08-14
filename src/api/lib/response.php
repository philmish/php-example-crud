<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\BaseCollection;
use mvcex\api\lib\BaseModel;
use mvcex\core\Response;

abstract class APIResponse implements Response {
    protected int $status;
    protected array $errors;
    protected BaseModel|BaseCollection|array|false $data;

    public function __construct(int $status, array $errors = [], BaseModel|BaseCollection|array|false $data = false)
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

    abstract static public function fromQueryResult(array $result, ?string ...$args): self;
}
