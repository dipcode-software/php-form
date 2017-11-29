<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\URLField;
use PHPForm\Widgets\URLInput;

class URLFieldTest extends TestCase
{
    public function setUp()
    {
        $this->field = new URLField();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(URLInput::class, $this->field->getWidget());
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testURLValidator()
    {
        $this->field->clean("invalid url");
    }

    public function testToNative()
    {
        $this->assertEquals("invalidurl", $this->field->toNative("invalid url"));
        $this->assertEquals("invalidrl", $this->field->toNative("invalid úrl"));
    }
}
