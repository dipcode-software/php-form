<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\BooleanField;
use PHPForm\Widgets\CheckboxInput;

class BooleanFieldTest extends TestCase
{
    public function testConstruct()
    {
        $field = new BooleanField();
        $this->assertInstanceOf(CheckboxInput::class, $field->getWidget());
    }

    public function testToNative()
    {
        $field = new BooleanField();
        $this->assertEquals($field->toNative(false), false);
        $this->assertEquals($field->toNative(true), true);
        $this->assertEquals($field->toNative("false"), false);
        $this->assertEquals($field->toNative("0"), false);
        $this->assertEquals($field->toNative("1"), true);
        $this->assertEquals($field->toNative("aa"), true);
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage This field is required.
     */
    public function testValidate()
    {
        $field = new BooleanField(array('required' => true));
        $field->clean(false);
    }

    public function testValidateValidValue()
    {
        $field = new BooleanField(array('required' => true));
        $this->assertTrue($field->clean(true));
    }
}
