<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\BooleanField;
use PHPForm\Widgets\BooleanInput;

class BooleanFieldTest extends TestCase
{
    // public function testConstruct()
    // {
    //     $field = new BooleanField();
    //     $this->assertInstanceOf(BooleanInput::class, $field->getWidget());
    // }

    public function testToNative()
    {
        $field = new BooleanField();
        $this->assertEquals($field->clean(false), false);
        $this->assertEquals($field->clean(true), true);
        $this->assertEquals($field->clean("false"), false);
        $this->assertEquals($field->clean("0"), false);
        $this->assertEquals($field->clean("1"), true);
        $this->assertEquals($field->clean("aa"), true);
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
}
