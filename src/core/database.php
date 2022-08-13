<?php declare(strict_types=1);

namespace mvcex\core;

interface Database {
    public function executeQuery(Query $query): Response|array;
}
