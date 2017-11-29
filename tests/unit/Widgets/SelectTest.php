<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\Select;

class SelectTest extends TestCase
{
    public function setUp()
    {
        $this->widget = new Select(["option1" => "option1", "option2" => "option2"], null);
    }

    public function testRender()
    {
        $render = $this->widget->render("name", null);

        $expected = '<select id="id_name" name="name">' .
                        '<option value="option1">option1</option>' .
                        '<option value="option2">option2</option>' .
                    '</select>';

        $this->assertXmlStringEqualsXmlString($expected, $render);
    }
}
