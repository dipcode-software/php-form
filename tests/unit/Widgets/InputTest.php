<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\Input;

class InputTest extends TestCase
{
    public function testGetContext()
    {
        $stub = $this->getMockForAbstractClass(Input::class);
        $context = $stub->getContext("name", "value");
        $this->assertArrayHasKey("type", $context);
    }

    public function testRender()
    {
        $stub = $this->getMockForAbstractClass(Input::class);
        $result = $stub->render("name", "value");
        $expected = '<input type="NULL" name="name" value="value"/>';
        $this->assertXmlStringEqualsXmlString($result, $expected);
    }

    public function testRenderWithoutValue()
    {
        $stub = $this->getMockForAbstractClass(Input::class);
        $result = $stub->render("name", null);
        $expected = '<input type="NULL" name="name" />';
        $this->assertXmlStringEqualsXmlString($result, $expected);
    }

    public function testRenderRequiredTrue()
    {
        $stub = $this->getMockForAbstractClass(Input::class);
        $stub->setRequired(true);
        $result = $stub->render("name", "value");
        $expected = '<input type="NULL" name="name" required="required" value="value"/>';
        $this->assertXmlStringEqualsXmlString($result, $expected);
    }
}
