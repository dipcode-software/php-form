<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\FileTypeValidator;
use PHPForm\Exceptions\ValidationError;

class FileTypeValidatorTest extends TestCase
{

    public function setUp()
    {
        $this->data = (object) array('type' => 'image/png');
    }

    public function testValidType()
    {
        $validator = new FileTypeValidator(['image/png']);

        $this->assertNull($validator($this->data));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Ensure the file is one of "image/jpeg" types (it has image/png).
     */
    public function testInvalidType()
    {
        $validator = new FileTypeValidator(['image/jpeg']);

        $validator($this->data);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Invalid type.
     */
    public function testInvalidEmailWithDifferentMessage()
    {
        $validator = new FileTypeValidator(['image/jpeg', "Invalid type."]);

        $validator($this->data);
    }
}
