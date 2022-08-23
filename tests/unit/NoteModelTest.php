<?php declare(strict_types=1);

use mvcex\api\services\notes\NoteModel;
use mvcex\core\Database;
use PHPUnit\Framework\TestCase;

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
             ->willReturn(["content" => "This is a test Note", "created" => "19.08.2022", "id" => 1, "author_id" => 23]);
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
     * @covers mvcex\api\services\notes\NoteModel
     */
    public function testReadNoteSuccess() {
        $data = ["id" => 1, "author_id" => 23];
        $model = NoteModel::Read($this->readSuccessStub, $data);
        $this->assertFalse($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\notes\NoteModel
     */
    public function testReadNoteFailure() {
        $incorecct = ["notId" => "test"];
        $incorrectInput = NoteModel::Read($this->readSuccessStub, $incorecct);
        $this->assertTrue($incorrectInput instanceof Exception);

        $this->expectException(TypeError::class);
        $nullInput = NoteModel::Read($this->readSuccessStub, null);

        $noResultInput = ["id" => 2, "author_id" => 24];
        $noResult = NoteModel::Read($this->failureStub, $noResultInput);
        $this->assertTrue($incorrectInput instanceof Exception);
    }
}
