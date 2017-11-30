<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\SelectMultiple;

class SelectMultipleTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new SelectMultiple(["option1" => "option1", "option2" => "option2"]);
    }

    public function testRender()
    {
        $expected = '<select id="id_name" multiple="multiple" name="name">' .
                        '<option value="option1">option1</option>' .
                        '<option value="option2">option2</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", null));
    }

    public function testRenderSelected()
    {
        $expected = '<select id="id_name" multiple="multiple" name="name">' .
                        '<option value="option1" selected="selected">option1</option>' .
                        '<option value="option2">option2</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", "option1"));
    }

    public function testRenderMultipleSelected()
    {
        $widget = new SelectMultiple([
            "option1" => "option1",
            "option2" => "option2",
            "option3" => "option3",
            "option4" => "option4",
        ]);

        $expected = '<select id="id_name" multiple="multiple" name="name">' .
                        '<option value="option1">option1</option>' .
                        '<option value="option2" selected="selected">option2</option>' .
                        '<option value="option3" selected="selected">option3</option>' .
                        '<option value="option4">option4</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $widget->render("name", ["option2", "option3"]));
    }
}
