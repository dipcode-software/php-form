<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\DateInput;

class DateInputTest extends TestCase
{
    public function testRender()
    {
        $date = date_create('2000-01-01');

        $widget = new DateInput();
        $render = $widget->render("name", $date);
        $this->assertXmlStringEqualsXmlString($render, '<input type="text" name="name" value="01/01/2000"/>');
    }
}
