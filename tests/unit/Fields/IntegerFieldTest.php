<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\IntegerField;
use PHPForm\Widgets\NumberInput;

class IntegerFieldTest extends TestCase
{
    public function setUp()
    {
        $this->field = new IntegerField(["min_value" => 10, "max_value" => 40]);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(NumberInput::class, $this->field->getWidget());
    }

    public function testConstructWithValidators()
    {
        $this->assertAttributeEquals(10, "min_value", $this->field);
        $this->assertAttributeEquals(40, "max_value", $this->field);
    }

    public function testValidatorNoException()
    {
        $this->assertEquals($this->field->clean("25"), 25);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMinValidatorError()
    {
        $this->field->clean("1");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMaxValidatorError()
    {
        $this->field->clean("100");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Enter a whole number.
     */
    public function testInvalidValue()
    {
        $this->field->clean("aa");
    }

    public function testWidgetAttrs()
    {
        $expected = array("min" => 10, "max" => 40);
        $this->assertEquals($this->field->widgetAttrs(null), $expected);
    }
}
