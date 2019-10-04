<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\FileField;
use PHPForm\Widgets\FileInput;
use stdClass;

class FileFieldTest extends TestCase
{
    public function setUp()
    {
        $this->field = new FileField(["max_size" => 20]);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(FileInput::class, $this->field->getWidget());
        $this->assertAttributeEquals(20, "max_size", $this->field);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage This field is required.
     */
    public function testValidateEmpty()
    {
        $data = array('size' => 0);
        $field = new FileField(["max_size" => 20, "required" => true]);
        $field->validate((object) $data);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage This field is required.
     */
    public function testValidateEmptyRequired()
    {
        $data = array('size' => 0);

        $field = new FileField(["required" => true]);
        $field->validate((object) $data);
    }


    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Ensure the file has at most 20 bytes (it has 100 bytes).
     */
    public function testValidateMaxSize()
    {
        $data = array('size' => 100);

        $this->field->validate((object) $data);
    }

    public function testToNative()
    {
        $data = array(
            'name' => 'mine_small.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/data/tmp/php/uploads/phpscF9Uz',
            'size' => 13481,
        );

        $result = $this->field->toNative($data);

        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['type'], $result->type);
        $this->assertEquals($data['tmp_name'], $result->tmp_name);
        $this->assertEquals($data['size'], $result->size);
    }

    public function testToNativeInvalidValue()
    {
        $result = $this->field->toNative(null);
        $this->assertNull($result);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testFileTypeValidatorCalled()
    {
        $data = array('size' => 10, 'type' => 'image/jpeg',);

        $field = new FileField(["valid_filetypes" => ['image/png']]);
        $field->clean($data);
    }
}
