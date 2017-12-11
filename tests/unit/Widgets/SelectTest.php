<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\Select;

class SelectTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new Select(["option1" => "option1", "option2" => "option2"]);
    }

    public function testRender()
    {
        $expected = '<select id="id_name" name="name">' .
                        '<option value="option1">option1</option>' .
                        '<option value="option2">option2</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", null));
    }

    public function testRenderFirstSelected()
    {
        $expected = '<select id="id_name" name="name">' .
                        '<option value="option1" selected="selected">option1</option>' .
                        '<option value="option2">option2</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", "option1"));
        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", ["option1", "option2"]));
    }

    public function testRenderOtherSelected()
    {
        $widget = new Select([
            "option1" => "option1",
            "option2" => "option2",
            "option3" => "option3",
            "option4" => "option4"
        ]);

        $expected = '<select id="id_name" name="name">' .
                        '<option value="option1">option1</option>' .
                        '<option value="option2">option2</option>' .
                        '<option value="option3" selected="selected">option3</option>' .
                        '<option value="option4">option4</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $widget->render("name", "option3"));
    }

    public function testRenderOptionWithouValue()
    {
        $widget = new Select([
            "" => "",
            "option2" => "option2",
            "option3" => "option3",
        ]);

        $expected = '<select id="id_name" name="name">' .
                        '<option></option>' .
                        '<option value="option2">option2</option>' .
                        '<option value="option3" selected="selected">option3</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $widget->render("name", "option3"));
    }
}
