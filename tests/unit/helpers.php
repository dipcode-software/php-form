<?php
namespace PHPForm\Unit;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function testPrettyName()
    {
        $this->assertEquals(prettyName("label_name"), 'Label name');
        $this->assertEquals(prettyName(""), '');
    }

    public function testSnakeToCamel()
    {
        $this->assertEquals(snakeToCamel("label_name"), 'LabelName');
        $this->assertEquals(snakeToCamel("label_with_name"), 'LabelWithName');
    }
}
