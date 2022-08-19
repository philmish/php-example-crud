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
    
    /**
     * Sends the status code and either the serialized errors or data.
     */
    public function send(): void {
        http_response_code($this->status);
        if (!$this->data) {
            echo json_encode($this->errors);
        } elseif (is_array($this->data) && !empty($this->data)) {
            echo json_encode($this->data);
        } else {
            echo $this->data->toJSON();
        }
        
    }
}
