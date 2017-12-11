<?php
namespace PHPForm\Unit\Forms;

use PHPUnit\Framework\TestCase;

use PHPForm\Forms\Form;
use PHPForm\Bounds\BoundField;

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
        $data = ["description" => "Description"];
        $form = new ExampleForm(['data' => $data]);

        $this->assertAttributeEquals(true, "is_bound", $form);
        $this->assertAttributeEquals($data, "data", $form);
    }

    public function testAddPrefix()
    {
        $form = new ExampleForm(["prefix" => "prefix"]);
        $this->assertAttributeEquals("prefix", "prefix", $form);
        $this->assertEquals($form->addPrefix("name"), "prefix-name");
    }

    public function testCssClasses()
    {
        $form = new ExampleForm();
        $this->assertAttributeEquals(["form-control"], "css_classes", $form);
        $this->assertEquals($form->getCssClasses(), ["form-control"]);
    }

    public function testFieldObjectAccess()
    {
        $form = new ExampleForm();
        $this->assertInstanceOf(BoundField::class, $form['description']);
        $this->assertInstanceOf(BoundField::class, $form['title']);
        $this->assertInstanceOf(BoundField::class, $form['email']);
    }

    public function testGetErrors()
    {
        $form = new ExampleForm();
        $this->assertEmpty($form->errors);
    }

    public function testGetNotDefinedAttribute()
    {
        $form = new ExampleForm();

        $this->assertNull($form->undefined);
    }

    public function testErrorsOfBoundedForm()
    {
        $form = new ExampleForm(["data" => array()]);
        $this->assertArrayHasKey("title", $form->errors);
    }

    public function testErrorsOfBoundedFormMaxLengthValidator()
    {
        $form = new ExampleForm(["data" => ["title" => "title", "description" => "Description"]]);
        $this->assertArrayHasKey("description", $form->errors);
    }

    public function testGetFieldErrors()
    {
        $form = new ExampleForm(["data" => array()]);
        $this->assertEquals(array("This field is required."), (array) $form->getFieldErrors("title"));
    }

    public function testClean()
    {
        $form = new ExampleForm(["data" => array("title" => "Title")]);
        $this->assertEquals(array("Error on title"), (array) $form->getFieldErrors("title"));
    }

    public function testCleanWithTwoAddError()
    {
        $form = new ExampleForm(["data" => array("title" => "Title2")]);
        $this->assertEquals(array("Error on title 1", "Error on title 2"), (array) $form->getFieldErrors("title"));
    }

    public function testCleanWithNonFieldError()
    {
        $form = new ExampleForm(["data" => array("title" => "title", "description" => "title")]);
        $this->assertEquals(array("Title and description can't be equal"), (array) $form->getNonFieldErrors());
    }

    public function testCleanWithValidationError()
    {
        $form = new ExampleForm(["data" => array("title" => "title", "email" => "test@unit.c")]);
        $this->assertEquals(array("Email invalid"), (array) $form->getNonFieldErrors());
    }

    public function testCleanEmail()
    {
        $form = new ExampleForm(["data" => array("title" => "title", "email" => "test2@unit.c")]);
        $this->assertEquals(array("Error Processing Email"), (array) $form->getFieldErrors("email"));
    }

    public function testGetCleanedData()
    {
        $form = new ExampleForm();
        $this->assertEmpty($form->getCleanedData());
    }

    public function testGetCleanedField()
    {
        $form = new ExampleForm(["data" => array("title" => "title")]);
        $form->isValid(); // force validation

        $this->assertEquals("title", $form->getCleanedField("title"));
        $this->assertEquals("", $form->getCleanedField("email"));
        $this->assertNull($form->getCleanedField("unexistent"));
    }

    public function testGetNonFieldErrorsEmpty()
    {
        $form = new ExampleForm([]);
        $result = $form->getNonFieldErrors();

        $this->assertEquals(0, count($result));
    }

    public function testGetNonFieldErrors()
    {
        $form = new ExampleForm(["data" => array("email" => "test@unit.c")]);
        $result = $form->getNonFieldErrors();

        $this->assertEquals(1, count($result));
    }

    public function testIsValidWithInvalidForm()
    {
        $form = new ExampleForm(["data" => array()]);
        $this->assertFalse($form->IsValid());
    }

    public function testIsValidWithValidForm()
    {
        $form = new ExampleForm(["data" => array("title" => "title")]);
        $this->assertTrue($form->IsValid());
    }

    public function testIsValidWithNoDataBounded()
    {
        $form = new ExampleForm();
        $this->assertFalse($form->IsValid());
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Field 'unexistent' not found in PHPForm\Unit\Forms\ExampleForm.
     * Choices are: title, description, email, disabled
     */
    public function testOffsetGetUnexistentField()
    {
        $form = new ExampleForm();
        $form["unexistent"];
    }

    public function testOffsetExists()
    {
        $form = new ExampleForm();

        $this->assertTrue(isset($form["disabled"]));
        $this->assertFalse(isset($form["unexistent"]));
    }

    public function testOffsetUnset()
    {
        $form = new ExampleForm();
        unset($form["disabled"]);

        $this->assertFalse(isset($form["disabled"]));
    }

    public function testCount()
    {
        $form = new ExampleForm();
        $this->assertEquals(4, count($form));
    }
}
