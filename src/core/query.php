<?php declare(strict_types=1);

namespace mvcex\core;

interface Query {
    public static function fromRuest(Request $request);
}
