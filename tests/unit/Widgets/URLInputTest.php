<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\URLInput;

class URLInputTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new URLInput();
    }

    public function testGetContext()
    {
        $context = $this->widget->getContext("name", "url");
        $this->assertEquals($context["type"], "url");
    }

    public function testRender()
    {
        $expected = $this->widget->render("name", "url");
        $this->assertXmlStringEqualsXmlString($expected, '<input type="url" id="id_name" name="name" value="url"/>');
    }
}
