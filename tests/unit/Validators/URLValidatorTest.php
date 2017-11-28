<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\URLValidator;
use PHPForm\Exceptions\ValidationError;

class URLValidatorTest extends TestCase
{
    public function testValidURL()
    {
        $validator = new URLValidator();
        $this->assertNull($validator("http://example.com"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Enter a valid URL.
     */
    public function testInvalidURL()
    {
        $validator = new URLValidator();
        $this->assertNull($validator("example.com"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Invalid URL.
     */
    public function testInvalidURLWithDifferentMessage()
    {
        $validator = new URLValidator("Invalid URL.");
        $this->assertNull($validator("example.com"));
    }
}
