<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\MultipleChoiceField;
use PHPForm\Widgets\SelectMultiple;

class MultipleChoiceFieldTest extends TestCase
{
    public function setUp()
    {
        $this->choices = array(
            "option1" => "Option 1",
            "option2" => "Option 2",
            "option3" => "Option 3"
        );

        $this->field = new MultipleChoiceField(["choices" => $this->choices, "required" => true]);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(SelectMultiple::class, $this->field->getWidget());
    }

    public function testToNative()
    {
        $this->assertEquals([], $this->field->toNative(false));
        $this->assertEquals(["1", "2", "3", "4"], $this->field->toNative([1, 2, 3, 4]));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Enter a list of values.
     */
    public function testToNativeNonArray()
    {
        $this->field->toNative("invalid value");
    }

    public function testValidateChoiceExistent()
    {
        $this->assertNull($this->field->validate(["option1", "option2"]));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage This field is required.
     */
    public function testValidateEmptyArray()
    {
        $this->field->validate([]);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Select a valid choice. "option5" is not one of the available choices.
     */
    public function testValidateChoiceUnexistent()
    {
        $this->field->validate(["option1", "option5"]);
    }
}
