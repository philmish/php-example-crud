<?php declare(strict_types=1);

use mvcex\core\Database;
use mvcex\api\lib\middleware\WaresChain;
use mvcex\api\services\notes\handlers\FetchNote;
use PHPUnit\Framework\TestCase;

/**
* @covers mvcex\api\services\notes\handlers\FetchNote;
*
* @uses mvcex\api\services\auth\middleware\LoginHandler;
* @uses mvcex\api\lib\middleware\WaresChain;
*/
final class FetchNoteHandlerTest extends TestCase {

    protected function setUp(): void {
        $this->successStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
    }

    private function noteData(): array {
        return [
            "id" => 1,
            "created" => "01.09.2022",
            "content" => "Test Note",
            "topic_id" => 1
        ];
    }

    private function queryData(): array {
        return [
            "id" => 1,
            "topic_id" => 1,
        ];
    }

    public function testFetchNoteSuccess():void {
        $this->successStub
             ->method('row')
             ->willReturn($this->noteData());

        $handler = new FetchNote();
        $chain = new WaresChain($this->queryData(), [$handler], $this->successStub);
        $result = $chain->runChain();
        $this->assertTrue($result->status === 200);
    }
}
