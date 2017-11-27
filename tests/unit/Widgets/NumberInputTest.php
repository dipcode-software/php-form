<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\NumberInput;

class NumberInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new NumberInput();
        $context = $widget->getContext("name", 10);
        $this->assertEquals($context["type"], "number");
    }

    public function testRender()
    {
        $widget = new NumberInput();
        $render = $widget->render("name", 10);
        $this->assertXmlStringEqualsXmlString($render, '<input type="number" id="id_name" name="name" value="10"/>');
    }
}
