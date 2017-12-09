<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\RadioSelect;

class RadioSelectTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new RadioSelect(["option1" => "option1", "option2" => "option2"]);
    }

    public function testRender()
    {
        $expected =
            '<ul id="id_name">' .
                '<li><label for="id_name_1">' .
                    '<input id="id_name_1" name="name" type="radio" value="option1"/> option1' .
                '</label></li>' .
                '<li><label for="id_name_2">' .
                    '<input id="id_name_2" name="name" type="radio" value="option2"/> option2'.
                '</label></li>' .
            '</ul>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", null));
    }

    public function testRenderChecked()
    {
        $expected =
            '<ul id="id_name">' .
                '<li><label for="id_name_1">' .
                    '<input id="id_name_1" name="name" type="radio" checked="checked" value="option1"/> option1' .
                '</label></li>' .
                '<li><label for="id_name_2">' .
                    '<input id="id_name_2" name="name" type="radio" value="option2"/> option2'.
                '</label></li>' .
            '</ul>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", "option1"));
        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", ["option1", "option2"]));
    }
}
