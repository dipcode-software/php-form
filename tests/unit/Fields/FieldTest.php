<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;
use PHPForm\Fields\Field;
use PHPForm\Fields\IntegerField;
use PHPForm\Fields\EmailField;
use PHPForm\Exceptions\ValidationError;

class FieldTest extends TestCase
{
    public function testConstruct()
    {
        $args = array("label" => "label", "required" => true);
        $stub = $this->getMockForAbstractClass(Field::class, array($args));
        $this->assertAttributeEquals(true, "required", $stub);
        $this->assertAttributeEquals("label", "label", $stub);
    }

    public function testSetDisabled()
    {
        $stub = $this->getMockForAbstractClass(Field::class);
        $stub->setDisabled(true);
        $this->assertAttributeEquals(true, 'disabled', $stub);
    }

    public function testToNative()
    {
        $stub = $this->getMockForAbstractClass(Field::class);
        $this->assertEquals($stub->toNative("test"), "test");
    }

    public function testValidate()
    {
        $stub = $this->getMockForAbstractClass(Field::class);
        $this->assertNull($stub->validate("test"));
    }

    public function testValidateWithEmptyValue()
    {
        $stub = $this->getMockForAbstractClass(Field::class);
        $this->assertNull($stub->validate(""));
        $this->assertNull($stub->validate(null));
        $this->assertNull($stub->validate([]));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage This field is required.
     */
    public function testValidateWithRequiredValueEmpty()
    {
        $args = array("required" => true);
        $stub = $this->getMockForAbstractClass(Field::class, array($args));
        $stub->validate(null);
    }

    public function testRunValidatorsWithEmptyValue()
    {
        $stub = $this->getMockForAbstractClass(Field::class);
        $this->assertNull($stub->runValidators(""));
        $this->assertNull($stub->runValidators(null));
        $this->assertNull($stub->runValidators([]));
    }
}
