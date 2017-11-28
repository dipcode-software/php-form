<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\MaxLengthValidator;
use PHPForm\Exceptions\ValidationError;

class MaxLengthValidatorTest extends TestCase
{
    public function testHigherLimit()
    {
        $validator = new MaxLengthValidator(10);
        $this->assertNull($validator("value"));
    }

    public function testEqualLimit()
    {
        $validator = new MaxLengthValidator(5);
        $this->assertNull($validator("value"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Ensure this value has at most 3 character (it has 5).
     */
    public function testLowerLimit()
    {
        $validator = new MaxLengthValidator(3);
        $this->assertNull($validator("value"));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Length higher than limit 3.
     */
    public function testLowerLimitWithDiffrentMessage()
    {
        $validator = new MaxLengthValidator(3, "Length higher than limit {limit}.");
        $this->assertNull($validator("value"));
    }
}
