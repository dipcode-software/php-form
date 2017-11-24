<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\MinLengthValidator;
use PHPForm\Exceptions\ValidationError;

class MinLengthValidatorTest extends TestCase
{
    public function testLowerLimit()
    {
        $validator = new MinLengthValidator(3);
        $this->assertNull($validator("value"));
    }

    public function testEqualLimit()
    {
        $validator = new MinLengthValidator(5);
        $this->assertNull($validator("value"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Ensure this value has at least 10 character (it has 5).
     */
    public function testHigherLimit()
    {
        $validator = new MinLengthValidator(10);
        $this->assertNull($validator("value"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Length lower than limit 10.
     */
    public function testHigherLimitWithDiffrentMessage()
    {
        $validator = new MinLengthValidator(10, "Length lower than limit {limit}.");
        $this->assertNull($validator("value"));
    }
}
