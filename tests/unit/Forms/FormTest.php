<?php
namespace PHPForm\Unit\Forms;

use PHPUnit\Framework\TestCase;
use Fleshgrinder\Core\Formatter;

use PHPForm\Forms\Form;
use PHPForm\Fields\BoundField;

class FormTest extends TestCase
{
    public function testConstructor()
    {
        $form = new ExampleForm();
        $this->assertAttributeEquals(false, "is_bound", $form);
        $this->assertAttributeEquals(null, "data", $form);
        $this->assertAttributeEquals(null, "files", $form);
        $this->assertAttributeEquals(null, "prefix", $form);
    }

    public function testConstructorWithBoundedForm()
    {
        $data = array("description" => "Description");
        $form = new ExampleForm($data);
        $this->assertAttributeEquals(true, "is_bound", $form);
        $this->assertAttributeEquals($data, "data", $form);
    }

    public function testAddPrefix()
    {
        $form = new ExampleForm(null, null, "prefix");
        $this->assertAttributeEquals("prefix", "prefix", $form);
        $this->assertEquals($form->addPrefix("name"), "prefix-name");
    }

    public function testFieldObjectAccess()
    {
        $form = new ExampleForm();
        $this->assertInstanceOf(BoundField::class, $form['description']);
        $this->assertInstanceOf(BoundField::class, $form['title']);
        $this->assertInstanceOf(BoundField::class, $form['email']);
    }

    public function testErrors()
    {
        $form = new ExampleForm();
        $this->assertEmpty($form->errors);
    }

    public function testErrorsOfBoundedForm()
    {
        $form = new ExampleForm(array());
        $this->assertArrayHasKey("title", $form->errors);
    }

    public function testErrorsOfBoundedFormMaxLengthValidator()
    {
        $form = new ExampleForm(array("title" => "title", "description" => "Description"));
        $this->assertArrayHasKey("description", $form->errors);
    }

    public function testGetFieldErrors()
    {
        $form = new ExampleForm(array());
        $this->assertEquals(array("This field is required."), (array) $form->getFieldErrors("title"));
    }

    public function testClean()
    {
        $form = new ExampleForm(array("title" => "Title"));
        $this->assertEquals(array("Error on title"), (array) $form->getFieldErrors("title"));
    }

    public function testCleanWithNonFieldError()
    {
        $form = new ExampleForm(array("title" => "title", "description" => "title"));
        $this->assertEquals(array("Title and description can't be equal"), (array) $form->getNonFieldErrors());
    }

    public function testCleanWithValidationError()
    {
        $form = new ExampleForm(array("title" => "title", "email" => "test@unit.c"));
        $this->assertEquals(array("Email invalid"), (array) $form->getNonFieldErrors());
    }
}
