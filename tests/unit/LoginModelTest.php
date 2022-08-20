<?php declare(strict_types=1);

use mvcex\core\Database;
use mvcex\api\services\auth\LoginModel;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase {
    /**
     * @covers mvcex\api\services\auth\LoginModel
     */
    public function testReadSuccess() {
        $dbStub = $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbStub->method('row')
               ->willReturn(["password" => "$1\$jwGbpR.A\$zYCjQtuXUwR.aauJuU8He0"]);
        $data = ["email" => "test@mail.com", "password" => "pass"];
        $model = LoginModel::Read($dbStub, $data);
        $this->assertFalse($model instanceof Exception);
    }

    public function testtoReadFailure() {
        $dbStub = $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbStub->method('row')
               ->willReturn(false);
        $data = ["email" => "test@mail.com", "password" => "pass"];
        $model = LoginModel::Read($dbStub, $data);
        $this->assertTrue($model instanceof Exception);
    }
}
