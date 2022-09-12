<?php declare(strict_types=1);

use mvcex\api\lib\middleware\WaresChain;
use mvcex\api\services\notes\handlers\CreateNote;
use PHPUnit\Framework\TestCase;

final class CreateNoteTest extends TestCase {

    protected function setUp(): void {
        $this->successStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
        $this->successStub
             ->method('insertOne')
             ->willReturn("3");
    }

    private function noteData(): array {
        return [
            "content" => "Inserted by tests",
            "topic_id" => 1
        ];
    }

    public function testCreateNoteSuccessChain():void {
        $handler = new CreateNote();
        $chain = new WaresChain(
            $this->noteData(),
            [$handler],
            $this->successStub
        );
        $response = $chain->runChain();
        $this->assertTrue($response->status === 200);
    }
}


