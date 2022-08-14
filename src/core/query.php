<?php declare(strict_types=1);

namespace mvcex\core;

use Closure;
use PDO;

final class Query {
    protected Closure $func;

    protected function __construct(callable $func) {
        $this->func = $func;
    }

    public function execute(PDO $db): array {
        $fn = $this->func;
        return $fn($db);
    }

    public static function fromRequest(Request $request): self {
        $func = $request->toQuery();
        return new self($func);
    }
}
