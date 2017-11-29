<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\TemporalInput;

class TemporalInputTest extends TestCase
{
    public function testConstructor()
    {
        $stub = $this->getMockForAbstractClass(TemporalInput::class);
        $this->assertAttributeEquals(null, "format", $stub);
    }

    public function testConstructorWithFormat()
    {
        $stub = $this->getMockForAbstractClass(TemporalInput::class, ["format"]);
        $this->assertAttributeEquals("format", "format", $stub);
    }

    public function testFormatValueDate()
    {
        $date = date_create('2000-01-01');
        $stub = $this->getMockForAbstractClass(TemporalInput::class, ["d/m/Y"]);
        $this->assertEquals($stub->formatValue($date), "01/01/2000");
    }

    public function testFormatValueString()
    {
        $stub = $this->getMockForAbstractClass(TemporalInput::class);
        $this->assertEquals($stub->formatValue("date"), "date");
    }

    public function testFormatValueOther()
    {
        $stub = $this->getMockForAbstractClass(TemporalInput::class);
        $this->assertEquals($stub->formatValue(true), "1");
    }
}
