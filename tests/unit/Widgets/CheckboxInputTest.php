<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\CheckboxInput;

class CheckboxInputTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new CheckboxInput();
    }

    public function testGetContext()
    {
        $context = $this->widget->getContext("name", 10);
        $this->assertEquals('checked="checked" id="id_name"', $context['attrs']);
    }

    public function testGetContextWithFalseValue()
    {
        $context = $this->widget->getContext("name", false);
        $this->assertEquals('id="id_name"', $context['attrs']);
    }

    public function testRender()
    {
        $render = $this->widget->render("name", "value");
        $expected = '<input type="checkbox" id="id_name" name="name" value="value" checked="checked"/>';
        $this->assertXmlStringEqualsXmlString($expected, $render);
    }

    public function testRenderNullValue()
    {
        $render = $this->widget->render("name", null);
        $expected = '<input type="checkbox" id="id_name" name="name"/>';
        $this->assertXmlStringEqualsXmlString($expected, $render);
    }

    public function testValueFromData()
    {
        $result = $this->widget->ValueFromData(["name" => "true"], [], "name");
        $this->assertTrue($result);
    }

    public function testValueFromDataNotExistent()
    {
        $result = $this->widget->ValueFromData(["name2" => "true"], [], "name");
        $this->assertFalse($result);
    }
}
