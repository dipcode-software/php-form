<?php
namespace PHPForm\Unit\Utils;

use PHPUnit\Framework\TestCase;

use PHPForm\Utils\Attributes;

class AttributesTest extends TestCase
{
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
