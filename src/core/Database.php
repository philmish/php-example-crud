<?php declare(strict_types=1);

namespace mvcex\core;

interface Database {
    public function row(string $stmt, ?array $args): array|false;
    public function rows(string $stmt, ?array $args): array|false;
    public function run(string $stmt, ?array $args): bool;
}
