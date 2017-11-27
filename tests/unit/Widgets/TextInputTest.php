<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\TextInput;

class TextInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new TextInput();
        $context = $widget->getContext("name", "value");
        $this->assertEquals($context["type"], "text");
    }

    public function testRender()
    {
        $widget = new TextInput();
        $render = $widget->render("name", "value");
        $this->assertXmlStringEqualsXmlString($render, '<input type="text" id="id_name" name="name" value="value"/>');
    }
}
