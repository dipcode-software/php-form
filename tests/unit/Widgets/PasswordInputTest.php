<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\PasswordInput;

class PasswordInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new PasswordInput();
        $context = $widget->getContext("name", null);
        $this->assertEquals($context["type"], "password");
    }

    public function testRender()
    {
        $widget = new PasswordInput();
        $render = $widget->render("name", "value");
        $this->assertXmlStringEqualsXmlString($render, '<input type="password" id="id_name" name="name"/>');
    }

    public function testFormatValue()
    {
        $widget = new PasswordInput();
        $this->assertNull($widget->formatValue("value"));
    }
}
