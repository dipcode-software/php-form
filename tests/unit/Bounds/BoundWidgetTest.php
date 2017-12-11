<?php
namespace PHPForm\Unit\Bounds;

use PHPUnit\Framework\TestCase;

use PHPForm\Bounds\BoundWidget;
use PHPForm\Widgets\RadioSelect;

class BoundWidgetTest extends TestCase
{

    protected function setUp()
    {
        $this->data = array(
            "for" => "for",
            "type" => "type",
            "name" => "name",
            "value" => "value",
            "label" => "label",
            "attrs" => array(),
            "template" => RadioSelect::TEMPLATE_CHOICE,
        );
    }

    public function testConstruct()
    {
        $bound = new BoundWidget($this->data);

        $this->assertAttributeEquals("for", "for", $bound);
        $this->assertAttributeEquals("type", "type", $bound);
        $this->assertAttributeEquals("name", "name", $bound);
        $this->assertAttributeEquals("value", "value", $bound);
        $this->assertAttributeEquals("label", "label", $bound);
        $this->assertAttributeEquals("radio_select_option.html", "template", $bound);
    }

    public function testToString()
    {
        $bound = new BoundWidget($this->data);

        $expected = '<label for="for"><input name="name" type="type" value="value"/> label</label>';
        $this->assertXmlStringEqualsXmlString((string) $bound, $expected);
    }
}
