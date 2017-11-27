<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\URLInput;

class URLInputTest extends TestCase
{
    public function testGetContext()
    {
        $widget = new URLInput();
        $context = $widget->getContext("name", "url");
        $this->assertEquals($context["type"], "url");
    }

    public function testRender()
    {
        $widget = new URLInput();
        $render = $widget->render("name", "url");
        $this->assertXmlStringEqualsXmlString($render, '<input type="url" id="id_name" name="name" value="url"/>');
    }
}
