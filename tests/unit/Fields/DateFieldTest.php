<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Fields\DateField;
use PHPForm\Widgets\DateInput;

class DateFieldTest extends TestCase
{
    public function testConstruct()
    {
        $field = new DateField();
        $this->assertInstanceOf(DateInput::class, $field->getWidget());
    }
}
