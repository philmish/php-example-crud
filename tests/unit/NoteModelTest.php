<?php declare(strict_types=1);

use mvcex\api\lib\exceptions\ApiException;
use mvcex\api\lib\exceptions\NotFound;
use mvcex\api\lib\exceptions\InvalidInputs;
use mvcex\api\services\notes\NoteModel;
use mvcex\core\Database;
use PHPUnit\Framework\TestCase;

/**
 * @covers mvcex\api\services\notes\NoteModel
 */
final class NotesModelTest extends TestCase {
    private Database $readSuccessStub;
    private Database $failureStub;

    protected function setUp():void {
        $this->readSuccessStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
        $this->readSuccessStub
             ->method('row')
             ->willReturn([
                 "content" => "This is a test Note",
                 "created" => "19.08.2022",
                 "id" => 1, "topic_id" => 23
             ]);
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
    public function testReadNoteSuccess() {
        $data = ["id" => 1, "topic_id" => 23];
        $model = NoteModel::Read($this->readSuccessStub, $data);
        $this->assertFalse($model instanceof ApiException);
    }

    public function testReadNoteFailure() {
        $incorecct = ["notId" => "test"];
        $incorrectInput = NoteModel::Read($this->readSuccessStub, $incorecct);
        $this->assertTrue($incorrectInput instanceof InvalidInputs);

        $nullInput = NoteModel::Read($this->readSuccessStub, null);
        $this->assertTrue($nullInput instanceof InvalidInputs);

        $noResultInput = ["id" => 2, "topic_id" => 24];
        $noResult = NoteModel::Read($this->failureStub, $noResultInput);
        $this->assertTrue($noResult instanceof NotFound);
    }
}
