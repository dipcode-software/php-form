<?php
namespace PHPForm\Unit;

use PHPUnit\Framework\TestCase;

use PHPForm\Messages;

class MessagesTest extends TestCase
{
    public function testSetMessages()
    {
        Messages::setMessages(["REQUIRED2" => "Required"]);

        $this->assertEquals("Required", Messages::format("REQUIRED2"));
    }

    public function testFormat()
    {
        $this->assertEquals("String", Messages::format("String"));
        $this->assertEquals("This field is required.", Messages::format("REQUIRED"));
    }

    public function testFormatWithContext()
    {
        $this->assertEquals("String unit", Messages::format("String {name}", ["name" => "unit"]));
        $this->assertEquals(
            "Ensure this value is greater than or equal to 10.",
            Messages::format("INVALID_MIN_VALUE", ["limit" => 10])
        );
    }
}
