<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\CheckboxSelectMultiple;

class CheckboxSelectMultipleTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new CheckboxSelectMultiple(["option1" => "option1", "option2" => "option2"]);
    }

    public function testRender()
    {
        $expected =
            '<div>' .
                '<label for="id_name_1">' .
                    '<input id="id_name_1" name="name[]" type="checkbox" value="option1"/> option1' .
                '</label>' .
                '<label for="id_name_2">' .
                    '<input id="id_name_2" name="name[]" type="checkbox" value="option2"/> option2'.
                '</label>' .
            '</div>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", null));
    }

    public function testRenderChecked()
    {
        $expected =
            '<div>' .
                '<label for="id_name_1">' .
                    '<input id="id_name_1" name="name[]" type="checkbox" checked="checked" value="option1"/> option1' .
                '</label>' .
                '<label for="id_name_2">' .
                    '<input id="id_name_2" name="name[]" type="checkbox" value="option2"/> option2'.
                '</label>' .
            '</div>';

        $this->assertXmlStringEqualsXmlString($expected, $this->widget->render("name", "option1"));
    }

    public function testRenderMultipleChecked()
    {
        $widget = new CheckboxSelectMultiple([
            "option1" => "option1",
            "option2" => "option2",
            "option3" => "option3",
            "option4" => "option4",
        ]);

        $expected =
            '<div>' .
                '<label for="id_name_1">' .
                    '<input id="id_name_1" name="name[]" type="checkbox" value="option1"/> option1' .
                '</label>' .
                '<label for="id_name_2">' .
                    '<input id="id_name_2" name="name[]" type="checkbox" checked="checked" value="option2"/> option2'.
                '</label>' .
                '<label for="id_name_3">' .
                    '<input id="id_name_3" name="name[]" type="checkbox" checked="checked" value="option3"/> option3'.
                '</label>' .
                '<label for="id_name_4">' .
                    '<input id="id_name_4" name="name[]" type="checkbox" value="option4"/> option4'.
                '</label>' .
            '</div>';

        $this->assertXmlStringEqualsXmlString($expected, $widget->render("name", ["option2", "option3"]));
    }
}
