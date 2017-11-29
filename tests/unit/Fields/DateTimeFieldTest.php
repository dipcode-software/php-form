<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Fields\DateTimeField;
use PHPForm\Widgets\DateTimeInput;

class DateTimeFieldTest extends TestCase
{

    public function setUp()
    {
        $this->field = new DateTimeField();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(DateTimeInput::class, $this->field->getWidget());
    }

    public function testConstructWithFormat()
    {
        $field = new DateTimeField(['format' => "d/m/Y H:i"]);
        $this->assertAttributeEquals("d/m/Y H:i", "format", $field);
    }

    public function testToNative()
    {
        $this->assertEquals(date_create('2000-01-01 20:50'), $this->field->toNative("01-01-2000 20:50"));
    }

    public function testToNativeEmptyValue()
    {
        $this->assertNull($this->field->toNative(""));
        $this->assertNull($this->field->toNative(null));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testToNativeInvalidDate()
    {
        $this->field->toNative("01/01/2000 20:50");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testToNativeInvalidDate2()
    {
        $this->field->toNative("test");
    }
}
