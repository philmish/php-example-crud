<?php declare(strict_types=1);

use mvcex\api\lib\exceptions\InvalidInputs;
use PHPUnit\Framework\TestCase;
use mvcex\api\lib\validation\Validator;

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
        $this->assertTrue($result);
    }
    /**
     * @covers mvcex\api\lib\Validator
     */
    public function testRequiredFilterFailing(): void {
        $rules = [
            "test" => "required"
        ];
        $data = ["notTest" => "test"];
        $validator = new Validator($rules);
        $result = $validator->run($data);
        $this->assertTrue($result instanceof InvalidInputs);
    }
}
