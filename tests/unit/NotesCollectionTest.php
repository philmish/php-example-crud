<?php declare(strict_types=1);

use mvcex\api\services\notes\NoteModel;
use mvcex\core\Database;
use PHPUnit\Framework\TestCase;
use mvcex\api\services\notes\NotesCollection;

final class NotesCollectionTest extends TestCase {

    /**
     * @covers mvcex\api\services\notes\NoteModel
     */
    public function testReadNoteSuccess() {
        $dbstub= $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbstub->method('rows')
               ->willReturn([["content" => "This is a test Note", "created" => "19.08.2022", "id" => 1, "author_id" => 23], ["content" => "second test note", "created" => "20.08.2022", "id" => 2, "author_id" => 23]]);
        $data = ["author_id" => 23];
        $model = NotesCollection::Read($dbstub, $data);
        $this->assertFalse($model instanceof Exception);
    }

    /**
     * @covers mvcex\api\services\notes\NoteModel
     */
    public function testReadNoteFailure() {
        $dbstub= $this->getMockBuilder(Database::class)
                       ->disableOriginalConstructor()
                       ->DisableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
        $dbstub->method('rows')->willReturn(false);
        $incorecct = ["not_author_Id" => "test"];
        $incorrectInput = NotesCollection::Read($dbstub, $incorecct);
        $this->assertTrue($incorrectInput instanceof Exception);

        $nullInput = NotesCollection::Read($dbstub, null);
        $this->assertTrue($nullInput instanceof Exception);

        $noResultInput = ["author_id" => 24];
        $noResult = NotesCollection::Read($dbstub, $noResultInput);
        $this->assertTrue($incorrectInput instanceof Exception);
    }
}
