<?php declare(strict_types=1);

namespace mvcex\core;

interface Response {
    public function send(): void;
}
