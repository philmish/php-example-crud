<?php declare(strict_types=1);

use mvcex\api\services\notes\NoteModel;
use mvcex\core\Database;
use PHPUnit\Framework\TestCase;

final class NotesModelTest extends TestCase {

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
        $dbstub->method('row')
               ->willReturn(["content" => "This is a test Note", "created" => "19.08.2022", "id" => 1, "author_id" => 23]);
        $data = ["id" => 1, "author_id" => 23];
        $model = NoteModel::Read($dbstub, $data);
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
        $dbstub->method('row')->willReturn(false);
        $incorecct = ["notId" => "test"];
        $incorrectInput = NoteModel::Read($dbstub, $incorecct);
        $this->assertTrue($incorrectInput instanceof Exception);

        $this->expectException(TypeError::class);
        $nullInput = NoteModel::Read($dbstub, null);

        $noResultInput = ["id" => 2, "author_id" => 24];
        $noResult = NoteModel::Read($dbstub, $noResultInput);
        $this->assertTrue($incorrectInput instanceof Exception);
    }
}
