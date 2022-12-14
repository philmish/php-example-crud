<?php declare(strict_types=1);

use mvcex\api\lib\middleware\WaresChain;
use PHPUnit\Framework\TestCase;
use mvcex\core\Database;
use mvcex\api\services\auth\handlers\LoginHandler;
use mvcex\api\lib\middleware\WaresContext;

/**
* @covers mvcex\api\services\auth\middleware\LoginHandler;
*
* @uses mvcex\api\services\auth\middleware\LoginHandler;
* @uses mvcex\api\lib\middleware\WaresChain;
*/
final class LoginHandlerTest extends TestCase {

    protected function setUp(): void {
        $this->successStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
        $this->successStub
             ->method("row")
             ->willReturn(["password" => "$1\$jwGbpR.A\$zYCjQtuXUwR.aauJuU8He0"]);
    }

    public function testLoginSuccess():void {
        $ctx = new WaresContext(["email" => "test@test.de", "password" => "Password123"]);
        $ctx->injectDB($this->successStub);
        $handler = new LoginHandler();
        $ctx = $handler->run($ctx);
        $this->assertFalse($ctx->done);
        $response = $ctx->toResponse();
        $this->assertTrue($response->status === 200);
    }

    public function testLoginSuccessInChain(): void {
        $handler = new LoginHandler();
        $data = ["email" => "test@test.de", "password" => "Password123"];
        $chain = new WaresChain($data, [$handler], $this->successStub);
        $response = $chain->runChain();
        $this->assertTrue($response->status === 200);
    }
}
