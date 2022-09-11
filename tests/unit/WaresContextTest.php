<?php declare(strict_types=1);

use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\api\lib\middleware\WaresContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers mvcex\api\lib\middleware\WaresContext
 *
 * @uses mvcex\api\lib\validation\Validator
 * 
 */
final class WaresContextTest extends TestCase {

    public function testSetErr(): void {
        $ctx = new WaresContext(["test"]);
        $ctx->setErr(new InvalidInputs("Test"));
        $this->assertTrue($ctx->done);
    }

    public function testValidation(): void {
        $ctx = new WaresContext(["test" => "test"]);
        $rules = ["test" => "required"];
        $ctx->validateData($rules);
        $this->assertFalse($ctx->done);

        $failingRules = ["new" => "required"];
        $ctx->validateData($failingRules);
        $this->assertTrue($ctx->done);
    }
}


