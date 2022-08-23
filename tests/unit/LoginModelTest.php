<?php declare(strict_types=1);

use mvcex\core\Database;
use mvcex\api\services\auth\LoginModel;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase {
    private Database $successStub;

    protected function setUp():void {
        $this->successStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
        $this->successStub
             ->method('row')
             ->willReturn(["password" => "$1\$jwGbpR.A\$zYCjQtuXUwR.aauJuU8He0"]);
        
        $this->failureStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
        $this->failureStub
             ->method('row')
             ->willReturn(false);
    }

    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testReadSuccess() {
        $data = ["email" => "test@mail.com", "password" => "pass"];
        $model = LoginModel::Read($this->successStub, $data);
        $this->assertFalse($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testReadFailure() {
        $data = ["email" => "test@mail.com", "password" => "pass"];
        $model = LoginModel::Read($this->failureStub, $data);
        $this->assertTrue($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testtoResponse() {
        $data = ["email" => "test@mail.com", "password" => "Password123"];
        $model = LoginModel::Read($this->successStub, $data);
        $this->assertFalse($model instanceof Exception);
        $response = $model->toResponse();
        $this->assertEquals($response->status, 200);
    }
}
