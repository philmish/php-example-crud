<?php declare(strict_types=1);

namespace mvcex\core;

interface Response {
    public function toJSON(): string;
    public function sendStatus(): void;
    static function fromQueryResult(array $result, ?string ...$args): self;
}
