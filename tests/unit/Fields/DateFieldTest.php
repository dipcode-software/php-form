<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Fields\DateField;
use PHPForm\Widgets\DateInput;

class DateFieldTest extends TestCase
{

    public function setUp()
    {
        $this->field = new DateField();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(DateInput::class, $this->field->getWidget());
    }

    public function testConstructWithFormat()
    {
        $field = new DateField(['format' => "d/m/Y"]);
        $this->assertAttributeEquals("d/m/Y", "format", $field);
    }

    public function testToNative()
    {
        $this->assertEquals(date_create('2000-01-01'), $this->field->toNative("01-01-2000"));
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
        $this->field->toNative("01/01/2000");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testToNativeInvalidDate2()
    {
        $this->field->toNative("test");
    }
}
