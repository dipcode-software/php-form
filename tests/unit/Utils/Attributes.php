<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Utils\Attributes;

class AttributesTest extends TestCase
{
    public function testFlatatt()
    {
        $attrs = array("name" => "name", "type" => "text");
        $this->assertEquals(Attributes::flatatt($attrs), 'name="name" type="text"');
        $this->assertEquals(Attributes::flatatt(array()), '');
        $this->assertEquals(Attributes::flatatt("string"), '');
    }

    public function testPrettyName()
    {
        $this->assertEquals(Attributes::prettyName("label_name"), 'Label name');
        $this->assertEquals(Attributes::prettyName(""), '');
    }

    public function testSnakeToCamel()
    {
        $this->assertEquals(Attributes::snakeToCamel("label_name"), 'LabelName');
        $this->assertEquals(Attributes::snakeToCamel("label_with_name"), 'LabelWithName');
    }
}
