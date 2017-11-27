<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\FileInput;

class FileInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new FileInput();
        $context = $widget->getContext("name", null);
        $this->assertEquals($context["type"], "file");
    }

    public function testRender()
    {
        $widget = new FileInput();
        $render = $widget->render("name", null);
        $this->assertXmlStringEqualsXmlString($render, '<input type="file" id="id_name" name="name"/>');
    }

    public function testFormatValue()
    {
        $widget = new FileInput();
        $this->assertNull($widget->formatValue("value"));
    }

    public function testValueFromDataWithoutData()
    {
        $widget = new FileInput();
        $this->assertNull($widget->valueFromData(array(), array(), "name"));
    }

    public function testValueFromDataWithData()
    {
        $widget = new FileInput();
        $value = $widget->valueFromData(array(), array("name" => "file"), "name");
        $this->assertEquals($value, "file");
    }
}
