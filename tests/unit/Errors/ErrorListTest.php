<?php
namespace PHPForm\Unit\Errors;

use PHPUnit\Framework\TestCase;

use PHPForm\Errors\ErrorList;

class ErrorListTest extends TestCase
{
    public function testToString()
    {
        $error = new ErrorList(array(1, 2, 3));
        $expected = '<ul class="errorlist"><li>1</li><li>2</li><li>3</li></ul>';
        $this->assertEquals((string) $error, $expected);
    }
}
