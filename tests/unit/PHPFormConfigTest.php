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
        $this->assertEquals(PHPFormConfig::getIMessage("REQUIRED"), "This field is required.");
        $this->assertNull(PHPFormConfig::getIMessage("Inexistent"));
    }

    public function testGetMessage()
    {
        $instance = PHPFormConfig::getInstance();

        $this->assertEquals($instance->getMessage("REQUIRED"), "This field is required.");
        $this->assertNull($instance->getMessage("Inexistent"));
    }

    public function testGetITemplate()
    {
        $this->assertEquals(PHPFormConfig::getITemplate("LABEL_REQUIRED"), '<span class="required">*</span>');
        $this->assertNull(PHPFormConfig::getITemplate("Inexistent"));
    }

    public function testGetTemplate()
    {
        $instance = PHPFormConfig::getInstance();

        $this->assertEquals($instance->getTemplate("LABEL_REQUIRED"), '<span class="required">*</span>');
        $this->assertNull($instance->getTemplate("Inexistent"));
    }

    public function testSetIMessages()
    {
        PHPFormConfig::setIMessages(array(
            "Invalid 2" => "Invalid 2",
            "Invalid 3" => "Invalid 3",
        ));

        $this->assertEquals("This field is required.", PHPFormConfig::getIMessage("REQUIRED"));
        $this->assertEquals("Invalid 2", PHPFormConfig::getIMessage("Invalid 2"));
        $this->assertEquals("Invalid 3", PHPFormConfig::getIMessage("Invalid 3"));
    }

    public function testSetMessages()
    {
        $instance = PHPFormConfig::getInstance();
        $instance->setMessages(array(
            "Invalid 2" => "Invalid 2",
            "Invalid 3" => "Invalid 3",
        ));

        $this->assertEquals("This field is required.", $instance->getMessage("REQUIRED"));
        $this->assertEquals("Invalid 2", $instance->getMessage("Invalid 2"));
        $this->assertEquals("Invalid 3", $instance->getMessage("Invalid 3"));
    }

    public function testSetITemplates()
    {
        PHPFormConfig::setITemplates(array(
            "Invalid 2" => "Invalid 2",
            "Invalid 3" => "Invalid 3",
        ));

        $this->assertEquals('<span class="required">*</span>', PHPFormConfig::getITemplate("LABEL_REQUIRED"));
        $this->assertEquals("Invalid 2", PHPFormConfig::getITemplate("Invalid 2"));
        $this->assertEquals("Invalid 3", PHPFormConfig::getITemplate("Invalid 3"));
    }

    public function testSetTemplates()
    {
        $instance = PHPFormConfig::getInstance();
        $instance->setTemplates(array(
            "Invalid 2" => "Invalid 2",
            "Invalid 3" => "Invalid 3",
        ));

        $this->assertEquals('<span class="required">*</span>', $instance->getTemplate("LABEL_REQUIRED"));
        $this->assertEquals("Invalid 2", $instance->getTemplate("Invalid 2"));
        $this->assertEquals("Invalid 3", $instance->getTemplate("Invalid 3"));
    }
}
