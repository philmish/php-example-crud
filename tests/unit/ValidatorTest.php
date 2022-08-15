<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mvcex\api\lib\Validator;

final class TestValidator extends TestCase {

    /**
     * @covers mvcex\api\lib\Validator
     */
    public function testRequiredFilter(): void {
        $rules = [
            "test" => "required"
        ];
        $data = ["test" => "test"];
        $validator = new Validator($rules);
        $result = $validator->run($data);
        $this->assertEmpty($result);
    }
}
