<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\CharField;
use PHPForm\Widgets\TextInput;

class CharFieldTest extends TestCase
{
    public function setUp()
    {
        $this->field = new CharField(["min_length" => 10, "max_length" => 20]);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(TextInput::class, $this->field->getWidget());
    }

    public function testConstructWithValidators()
    {
        $this->assertAttributeEquals(10, "min_length", $this->field);
        $this->assertAttributeEquals(20, "max_length", $this->field);
    }

    public function testValidatorNoException()
    {
        $this->assertEquals($this->field->clean("12345678910"), "12345678910");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMinValidator()
    {
        $this->field->clean("12345");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testMaxValidator()
    {
        $this->field->clean("123456789123456789123456789");
    }

    public function testWidgetAttrs()
    {
        $expected = array("minlength" => 10, "maxlength" => 20);
        $this->assertEquals($expected, $this->field->widgetAttrs(null));
    }
}
