<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\EmailInput;

class EmailInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new EmailInput();
        $context = $widget->getContext("name", null);
        $this->assertEquals($context["type"], "email");
    }

    public function testRender()
    {
        $widget = new EmailInput();
        $render = $widget->render("name", "s@m.c");
        $this->assertXmlStringEqualsXmlString($render, '<input type="email" id="id_name" name="name" value="s@m.c"/>');
    }
}
