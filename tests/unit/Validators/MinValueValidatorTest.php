<?php
namespace PHPForm\Unit\Validators;

use PHPUnit\Framework\TestCase;

use PHPForm\Validators\MinValueValidator;
use PHPForm\Exceptions\ValidationError;

class MinValueValidatorTest extends TestCase
{
    public function testLowerValueLimit()
    {
        $validator = new MinValueValidator(10);
        $this->assertNull($validator(50));
    }

    public function testEqualValueLimit()
    {
        $validator = new MinValueValidator(10);
        $this->assertNull($validator(10));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Ensure this value is greater than or equal to 20.
     */
    public function testHigherValueLimit()
    {
        $validator = new MinValueValidator(20);
        $this->assertNull($validator(15));
    }

    /**
     * @expectedException PHPForm\Exceptions\ValidationError
     * @expectedExceptionMessage Value lower than limit 20.
     */
    public function testHigherValueLimitWithDiffrentMessage()
    {
        $validator = new MinValueValidator(20, "Value lower than limit {limit}.");
        $this->assertNull($validator(15));
    }
}
