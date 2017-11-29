<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\Textarea;

class TextareaTest extends TestCase
{
    public function testConstructor()
    {
        $widget = new Textarea();
        $result = $widget->render("name", "value");
        $expected = '<textarea id="id_name" name="name" cols="40" rows="5">value</textarea>';
        $this->assertXmlStringEqualsXmlString($result, $expected);
    }

    public function testConstructorWithArgs()
    {
        $widget = new Textarea(null, array("cols" => 20));
        $result = $widget->render("name", "value");
        $expected = '<textarea id="id_name" name="name" cols="20" rows="5">value</textarea>';
        $this->assertXmlStringEqualsXmlString($result, $expected);
    }

    public function testRenderWithoutValue()
    {
        $widget = new Textarea(null, array("cols" => 20));
        $result = $widget->render("name", null);
        $expected = '<textarea id="id_name" name="name" cols="20" rows="5"></textarea>';
        $this->assertXmlStringEqualsXmlString($result, $expected);
    }
}
