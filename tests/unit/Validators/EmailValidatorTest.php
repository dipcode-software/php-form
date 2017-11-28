<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\EmailValidator;
use PHPForm\Exceptions\ValidationError;

class EmailValidatorTest extends TestCase
{
    public function testValidEmail()
    {
        $validator = new EmailValidator();
        $this->assertNull($validator("user@example.com"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Enter a valid email address.
     */
    public function testInvalidEmail()
    {
        $validator = new EmailValidator();
        $this->assertNull($validator("@example.com"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Invalid email.
     */
    public function testInvalidEmailWithDifferentMessage()
    {
        $validator = new EmailValidator("Invalid email.");
        $this->assertNull($validator("@example.com"));
    }
}
