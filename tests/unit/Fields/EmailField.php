<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\EmailField;
use PHPForm\Widgets\EmailInput;

class EmailFieldTest extends TestCase
{
    public function testConstruct()
    {
        $field = new EmailField();
        $this->assertInstanceOf(EmailInput::class, $field->getWidget());
    }

    public function testEmailValidatorSuccess()
    {
        $field = new EmailField();
        $this->assertEquals($field->clean("unit@example.com"), "unit@example.com");
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     */
    public function testEmailValidator()
    {
        $field = new EmailField();
        $field->clean("@example.com");
    }
}
