<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\MaxValueValidator;
use PHPForm\Exceptions\ValidationError;

class MaxValueValidatorTest extends TestCase
{
    public function testHigherValueLimit()
    {
        $validator = new MaxValueValidator(10);
        $this->assertNull($validator(9));
    }

    public function testEqualValueLimit()
    {
        $validator = new MaxValueValidator(10);
        $this->assertNull($validator(10));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Ensure this value is less than or equal to 10.
     */
    public function testLowerValueLimit()
    {
        $validator = new MaxValueValidator(10);
        $this->assertNull($validator(15));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Value higher than limit 10.
     */
    public function testLowerValueLimitWithDiffrentMessage()
    {
        $validator = new MaxValueValidator(10, "Value higher than limit {limit}.");
        $this->assertNull($validator(15));
    }
}
