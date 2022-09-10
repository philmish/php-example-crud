<?php declare(strict_types=1);

use mvcex\api\lib\exceptions\InvalidInputs;
use PHPUnit\Framework\TestCase;
use mvcex\api\lib\validation\Validator;


/**
 * @covers mvcex\api\lib\Validator
 */
final class TestValidator extends TestCase {

    public function testRequiredFilter(): void {
        $rules = [
            "test" => "required"
        ];
        $data = ["test" => "test"];
        $validator = new Validator($rules);
        $result = $validator->run($data);
        $this->assertTrue($result);
    }

    public function testRequiredFilterFailing(): void {
        $rules = [
            "test" => "required"
        ];
        $data = ["notTest" => "test"];
        $validator = new Validator($rules);
        $result = $validator->run($data);
        $this->assertTrue($result instanceof InvalidInputs);
    }

    public function testIsArrayFilterSuccess(): void {
        $data = [
            "test" => ["test" => "test"],
        ];
        $rules = ["test" => "array",];
        $validator = new Validator($rules);
        $result = $validator->run($data);
        $this->assertFalse($result instanceof InvalidInputs);
    }
}
