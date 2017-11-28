<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Fields\DateTimeField;
use PHPForm\Widgets\DateTimeInput;

class DateTimeFieldTest extends TestCase
{
    public function testConstruct()
    {
        $field = new DateTimeField();
        $this->assertInstanceOf(DateTimeInput::class, $field->getWidget());
    }
}
