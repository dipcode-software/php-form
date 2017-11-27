<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\HiddenInput;

class HiddenInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new HiddenInput();
        $context = $widget->getContext("name", 10);
        $this->assertEquals($context["type"], "hidden");
    }

    public function testRender()
    {
        $widget = new HiddenInput();
        $render = $widget->render("name", 10);
        $this->assertXmlStringEqualsXmlString($render, '<input type="hidden" id="id_name" name="name" value="10"/>');
    }
}
