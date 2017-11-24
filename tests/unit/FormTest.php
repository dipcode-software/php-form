<?php
namespace PHPForm\Unit;

use PHPUnit\Framework\TestCase;
use PHPForm\Form;

class FormTest extends TestCase
{
    public function testItWorks()
    {
        $form = new Form($b = "Sandro");
        $this->assertTrue(true);
    }
}
