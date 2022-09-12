<?php declare(strict_types=1);

namespace mvcex\api\lib\middleware;

use mvcex\api\lib\APIResponse;
use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\api\lib\validation\Validator;
use mvcex\core\Database;

final class WaresContext {
    protected ?Database $db;
    protected ?array $data;
    protected ?ApiException $error;
    public bool $done;

    public function __construct(?array $data) {
        $this->data = $data;
        $this->error = null;
        $this->done = false;
        $this->db = null;
    }

    public function setErr(ApiException $err): void {
        $this->error = $err;
        $this->done = true;
    }

    public function setData(array $data): void {
        $this->data = $data;;
    }

    public function addData(array $data): void {
        if (!$this->data) {
            $this->data = $data;
            return;
        }
        $this->data = array_merge($this->data, $data);
    }

    public function validateData(array $rules): void {
        if (!$this->data) {
            $err = new InvalidInputs("Missing Input");
            $this->setErr($err);
            return;
        }
        $v = new Validator($rules);
        $r = $v->run($this->data);
        if ($r instanceof InvalidInputs) {
            $this->setErr($r);
        }
    }

    public function injectDB(Database $db): void {
        $this->db = $db;
    }

    public function getDB(): ?Database {
        return $this->db;
    }

    public function getData(): ?array {
        return $this->data;
    }

    public function toResponse(): APIResponse {
        if ($this->error) {
            return $this->error->toResponse();
        }
        if (!$this->data) {
            $this->data = ["status" => "success"];
        }
        return new APIResponse(200, [], $this->data);
    }
}
