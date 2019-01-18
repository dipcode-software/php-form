<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\ChoiceField;
use PHPForm\Widgets\Select;

class ChoiceFieldTest extends TestCase
{
    public function setUp()
    {
        $this->choices = array("option1" => "Option1");
        $this->field = new ChoiceField(["choices" => $this->choices, "required" => true]);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(Select::class, $this->field->getWidget());
    }

    public function testSetChoices()
    {
        $this->assertAttributeEquals($this->choices, "choices", $this->field);
        $this->assertAttributeEquals($this->choices, "choices", $this->field->getWidget());

        $choices = array("option1" => "Option1");
        $this->field->setChoices($choices);

        $this->assertAttributeEquals($choices, "choices", $this->field);
        $this->assertAttributeEquals($choices, "choices", $this->field->getWidget());
    }

    public function testToNative()
    {
        $this->assertEquals("", $this->field->toNative(false));
        $this->assertEquals("1", $this->field->toNative(true));
        $this->assertEquals("false", $this->field->toNative("false"));
        $this->assertEquals("0", $this->field->toNative("0"));
        $this->assertEquals("0", $this->field->toNative(0));
        $this->assertEquals("1", $this->field->toNative("1"));
        $this->assertEquals("aa", $this->field->toNative("aa"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage This field is required.
     */
    public function testValidate()
    {
        $this->field->validate("");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Select a valid choice. "option2" is not one of the available choices.
     */
    public function testValidateChoiceUnexistent()
    {
        $this->field->validate("option2");
    }

    public function testValidateValidValue()
    {
        $this->assertNull($this->field->validate("option1"));
    }
}
