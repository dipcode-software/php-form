<?php
namespace PHPForm\Unit\Widgets;

use PHPUnit\Framework\TestCase;

use PHPForm\Widgets\Widget;

class WidgetTest extends TestCase
{
    public function setUp()
    {
        $this->widget = $this->getMockForAbstractClass(Widget::class);
    }

    public function testGetOptions()
    {
        $options = $this->widget->getOptions("name", "value");
        $this->assertEquals(array(), $options);
    }

    public function testValueFromData()
    {
        $result = $this->widget->valueFromData(array("name" => "value"), array(), "name");
        $this->assertEquals("value", $result);
    }

    public function testValueFromDataInexistent()
    {
        $result = $this->widget->valueFromData(array(), array(), "name");
        $this->assertNull($result);
    }

    public function testBuildAutoId()
    {
        $this->assertEquals("id_name", $this->widget->buildAutoId("name"));
        $this->assertEquals("id_name_1", $this->widget->buildAutoId("name", 1));
    }
}
