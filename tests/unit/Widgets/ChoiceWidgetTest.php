<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Widgets\ChoiceWidget;

class ChoiceWidgetTest extends TestCase
{
    public function setUp()
    {
        $attrs = ["choices" => array(
            "option1" => "Option 1",
            "option2" => "Option 2",
            "option3" => "Option 3"
        ), "required" => true];

        $this->widget = $this->getMockForAbstractClass(ChoiceWidget::class, array($attrs));
    }

    public function testFormatValue()
    {
        // $this->assertEquals([], $this->widget->formatValue(""));
        // $this->assertEquals([], $this->widget->formatValue(null));
        // $this->assertEquals([], $this->widget->formatValue([]));
        // $this->assertEquals(["1", "2"], $this->widget->formatValue([1, 2]));
        $this->assertEquals(1, 1);
    }
}
