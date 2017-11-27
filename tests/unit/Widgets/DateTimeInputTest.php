<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\DateTimeInput;

class DateTimeInputTest extends TestCase
{
    public function testRender()
    {
        $date = date_create('2000-01-01');

        $widget = new DateTimeInput();
        $render = $widget->render("name", $date);
        $expected = '<input type="text" id="id_name" name="name" value="01/01/2000 00:00"/>';
        $this->assertXmlStringEqualsXmlString($render, $expected);
    }
}
