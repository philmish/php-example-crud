<?php declare(strict_types=1);

namespace mvcex\api\lib\validation;

use PHPUnit\Framework\TestCase;
use mvcex\api\lib\validation\Filter;

final class TestFilter extends TestCase {
    /**
     * @covers mvcex\api\lib\Validator
     */
    public function testRequiredFilter(): void {
        $filter = new Required(["test"]);
        $data = [
            "notTest" => "test"
        ];
        $errors = [];
        $result = $filter->runFilter($data, $errors);
        $this->assertFalse(empty($result));
    }
} 
