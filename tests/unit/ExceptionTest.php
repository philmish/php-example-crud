<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mvcex\api\lib\exceptions\InvalidInputs;


/**
 * @covers mvcex\api\lib\exceptions\InvalidInputs
 * 
 * @uses mvcex\api\lib\exceptions\InvalidInputs
 */
final class TestInvalidInputs extends TestCase {

    public function testExceptionCreation(): void {
        $err = new InvalidInputs("This is a test exception.", [["field1" => "Missing stuff"]]);
        $resp = $err->toResponse();
        $this->assertTrue($err->getCode() === $resp->status);
    }
}
