<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\IntegerField;
use PHPForm\Widgets\NumberInput;

class IntegerFieldTest extends TestCase
{
    public function testConstruct()
    {
        $field = new IntegerField();
        $this->assertInstanceOf(NumberInput::class, $field->getWidget());
    }

    public function testConstructWithValidators()
    {
        $args = array("min_value" => 10, "max_value" => 40);
        $field = new IntegerField($args);
        $this->assertAttributeEquals(10, "min_value", $field);
        $this->assertAttributeEquals(40, "max_value", $field);
    }

    public function testValidatorNoException()
    {
        $args = array("min_value" => 10, "max_value" => 40);
        $field = new IntegerField($args);
        $this->assertEquals($field->clean("25"), 25);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMinValidatorError()
    {
        $args = array("min_value" => 10, "max_value" => 40);
        $field = new IntegerField($args);
        $field->clean("1");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMaxValidatorError()
    {
        $args = array("min_value" => 10, "max_value" => 20);
        $field = new IntegerField($args);
        $field->clean("100");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Enter a whole number.
     */
    public function testInvalidValue()
    {
        $field = new IntegerField();
        $field->clean("aa");
    }

    public function testWidgetAttrs()
    {
        $args = array("min_value" => 10, "max_value" => 40);
        $field = new IntegerField($args);

        $expected = array("min" => 10, "max" => 40);
        $this->assertEquals($field->widgetAttrs(null), $expected);
    }
}
