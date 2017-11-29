<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\SelectMultiple;

class SelectMultipleTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new SelectMultiple(["option1" => "option1", "option2" => "option2"], null);
    }

    public function testRender()
    {
        $render = $this->widget->render("name", null);

        $expected = '<select id="id_name" multiple="multiple" name="name">' .
                        '<option value="option1">option1</option>' .
                        '<option value="option2">option2</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $render);
    }
}
