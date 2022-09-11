<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mvcex\api\lib\validation\Required;

/**
 * @covers mvcex\api\lib\validation\Required
 */
final class TestFilter extends TestCase {
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
