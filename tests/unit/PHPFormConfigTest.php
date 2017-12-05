<?php
namespace PHPForm\Unit;

use PHPUnit\Framework\TestCase;

use PHPForm\PHPFormConfig;

class PHPFormConfigTest extends TestCase
{
    public function testGetInstance()
    {
        $this->assertNotNull(PHPFormConfig::getInstance());
    }

    public function testGetIMessage()
    {
        $this->assertEquals(PHPFormConfig::getIMessage("Invalid"), "Invalid");
        $this->assertNull(PHPFormConfig::getIMessage("Inexistent"));
    }

    public function testGetMessage()
    {
        $instance = PHPFormConfig::getInstance();

        $this->assertEquals($instance->getMessage("Invalid"), "Invalid");
        $this->assertNull($instance->getMessage("Inexistent"));
    }

    public function testGetITemplate()
    {
        $this->assertEquals(PHPFormConfig::getITemplate("Invalid"), "Invalid");
        $this->assertNull(PHPFormConfig::getITemplate("Inexistent"));
    }

    public function testGetTemplate()
    {
        $instance = PHPFormConfig::getInstance();

        $this->assertEquals($instance->getTemplate("Invalid"), "Invalid");
        $this->assertNull($instance->getTemplate("Inexistent"));
    }

    public function testSetMessages()
    {
        $instance = PHPFormConfig::getInstance();
        $instance->setMessages(array(
            "Invalid 2" => "Invalid 2",
            "Invalid 3" => "Invalid 3",
        ));

        $this->assertEquals("Invalid", $instance->getMessage("Invalid"));
        $this->assertEquals("Invalid 2", $instance->getMessage("Invalid 2"));
        $this->assertEquals("Invalid 3", $instance->getMessage("Invalid 3"));
    }

    public function testSetTemplates()
    {
        $instance = PHPFormConfig::getInstance();
        $instance->setTemplates(array(
            "Invalid 2" => "Invalid 2",
            "Invalid 3" => "Invalid 3",
        ));

        $this->assertEquals("Invalid", $instance->getTemplate("Invalid"));
        $this->assertEquals("Invalid 2", $instance->getTemplate("Invalid 2"));
        $this->assertEquals("Invalid 3", $instance->getTemplate("Invalid 3"));
    }
}
