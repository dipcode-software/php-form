<?php
namespace PHPForm\Unit\Exceptions;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;

class ValidationErrorTest extends TestCase
{
    public function testGetErrorList()
    {
        $error = new ValidationError("Invalid field");
        $this->assertEquals(array("Invalid field"), $error->getErrorList());
    }

    public function testGetErrorListWithArray()
    {
        $error = new ValidationError(array("Invalid field"));
        $this->assertEquals(array("Invalid field"), $error->getErrorList());
    }

    public function testGetMessageCode()
    {
        $error = new ValidationError("Invalid field", "code");
        $this->assertEquals("code", $error->getMessageCode());
    }
}
