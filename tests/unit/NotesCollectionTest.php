<?php declare(strict_types=1);

use mvcex\api\services\notes\NoteModel;
use mvcex\core\Database;
use PHPUnit\Framework\TestCase;
use mvcex\api\services\notes\NotesCollection;

final class NotesCollectionTest extends TestCase {
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
             ->method('rows')
             ->willReturn([["content" => "This is a test Note", "created" => "19.08.2022", "id" => 1, "topic_id" => 23], ["content" => "second test note", "created" => "20.08.2022", "id" => 2, "topic_id" => 23]]);
        $this->failureStub = $this->getMockBuilder(Database::class)
                                  ->disableOriginalConstructor()
                                  ->DisableOriginalClone()
                                  ->disableArgumentCloning()
                                  ->disallowMockingUnknownTypes()
                                  ->getMock();
        $this->failureStub
             ->method('rows')
             ->willReturn(false);
    }

    /**
     * @covers mvcex\api\services\notes\NoteModel
     */
    public function testReadNoteSuccess() {
        $data = ["topic_id" => 23];
        $model = NotesCollection::Read($this->readSuccessStub, $data);
        $this->assertFalse($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\notes\NoteModel
     */
    public function testReadNoteFailure() {
        $incorecct = ["not_author_Id" => "test"];
        $incorrectInput = NotesCollection::Read($this->readSuccessStub, $incorecct);
        $this->assertTrue($incorrectInput instanceof Exception);

        $nullInput = NotesCollection::Read($this->readSuccessStub, null);
        $this->assertTrue($nullInput instanceof Exception);

        $noResultInput = ["topic_id" => 24];
        $noResult = NotesCollection::Read($this->failureStub, $noResultInput);
        $this->assertTrue($noResult instanceof Exception);
    }
}
