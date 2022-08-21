<?php declare(strict_types=1);

use mvcex\core\Database;
use mvcex\api\services\auth\LoginModel;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase {

    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testReadSuccess() {
        $dbstub= $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbstub->method('row')
               ->willReturn(["password" => "$1\$jwGbpR.A\$zYCjQtuXUwR.aauJuU8He0"]);
        $data = ["email" => "test@mail.com", "password" => "pass"];
        $model = LoginModel::Read($dbstub, $data);
        $this->assertFalse($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testReadFailure() {
        $dbstub= $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbstub->method('row')
               ->willReturn(false);
        $data = ["email" => "test@mail.com", "password" => "pass"];
        $model = LoginModel::Read($dbstub, $data);
        $this->assertTrue($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testtoResponse() {
        $dbstub= $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbstub->method('row')
               ->willReturn(["password" => "$1\$jwGbpR.A\$zYCjQtuXUwR.aauJuU8He0"]);
        $data = ["email" => "test@mail.com", "password" => "Password123"];
        $model = LoginModel::Read($dbstub, $data);
        $this->assertFalse($model instanceof Exception);
        $response = $model->toResponse();
        $this->assertEquals($response->status, 200);
    }
}
