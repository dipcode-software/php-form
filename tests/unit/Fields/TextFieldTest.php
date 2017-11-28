<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\CharField;
use PHPForm\Widgets\TextInput;

class CharFieldTest extends TestCase
{
    public function testConstruct()
    {
        $field = new CharField();
        $this->assertInstanceOf(TextInput::class, $field->getWidget());
    }

    public function testConstructWithValidators()
    {
        $args = array("min_length" => 10, "max_length" => 40);
        $field = new CharField($args);
        $this->assertAttributeEquals(10, "min_length", $field);
        $this->assertAttributeEquals(40, "max_length", $field);
    }

    public function testValidatorNoException()
    {
        $args = array("min_length" => 10, "max_length" => 40);
        $field = new CharField($args);
        $this->assertEquals($field->clean("12345678910"), "12345678910");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMinValidator()
    {
        $args = array("min_length" => 10, "max_length" => 40);
        $field = new CharField($args);
        $field->clean("12345");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMaxValidator()
    {
        $args = array("min_length" => 10, "max_length" => 20);
        $field = new CharField($args);
        $field->clean("123456789123456789123456789");
    }

    public function testWidgetAttrs()
    {
        $args = array("min_length" => 10, "max_length" => 40);
        $field = new CharField($args);

        $expected = array("minlength" => 10, "maxlength" => 40);
        $this->assertEquals($field->widgetAttrs(null), $expected);
    }
}
