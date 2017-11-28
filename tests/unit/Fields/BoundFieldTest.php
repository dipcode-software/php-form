<?php
namespace PHPForm\Unit\Fields;

use PHPUnit\Framework\TestCase;

use PHPForm\Errors\ErrorList;
use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\BoundField;
use PHPForm\Fields\CharField;
use PHPForm\Forms\Form;

class BoundFieldTest extends TestCase
{
    protected function setUp()
    {
        $this->simple_form = $this->getMockForAbstractClass(Form::class);
        $this->simple_field = new CharField();
    }

    public function testConstruct()
    {
        $bound = new BoundField($this->simple_form, $this->simple_field, "name");

        $this->assertAttributeEquals("name", "html_name", $bound);
        $this->assertAttributeEquals("Name", "label", $bound);
        $this->assertAttributeEquals("", "help_text", $bound);
    }

    public function testConstructWithPrefix()
    {
        $form = $this->getMockForAbstractClass(Form::class, array(null, null, "form"));
        $bound = new BoundField($form, $this->simple_field, "name");

        $this->assertAttributeEquals("form-name", "html_name", $bound);
    }

    public function testConstructWithHelpText()
    {
        $field = new CharField(array("help_text" => "Help"));
        $bound = new BoundField($this->simple_form, $field, "name");

        $this->assertAttributeEquals("Help", "help_text", $bound);
    }

    public function testConstructWithLabel()
    {
        $field = new CharField(array("label" => "Label"));
        $bound = new BoundField($this->simple_form, $field, "name");

        $this->assertAttributeEquals("Label", "label", $bound);
    }

    public function testGetErrors()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");
        $this->assertInstanceOf(ErrorList::class, $bound->errors);
    }

    public function testSimpleGet()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");
        $this->assertEquals($bound->label, "Name");
    }

    public function testToString()
    {
        $form = $this->getMockForAbstractClass(Form::class, array(array("name" => "value")));
        $bound = new BoundField($form, $this->simple_field, "name");
        $expected = '<input type="text" id="id_name" name="name" value="value"/>';
        $this->assertXmlStringEqualsXmlString((string) $bound, $expected);
    }

    public function testToStringWithPrefix()
    {
        $data = array("prefix-name" => "value");
        $form = $this->getMockForAbstractClass(Form::class, array($data, null, "prefix"));
        $bound = new BoundField($form, $this->simple_field, "name");
        $expected = '<input type="text" id="id_prefix-name" name="prefix-name" value="value"/>';
        $this->assertXmlStringEqualsXmlString((string) $bound, $expected);
    }

    public function testLabelTag()
    {
        $field = new CharField(array("label" => "Label"));
        $bound = new BoundField($this->simple_form, $field, "name");
        $expected = '<label for="id_name">Label</label>';
        $this->assertXmlStringEqualsXmlString($bound->labelTag(), $expected);
    }

    public function testLabelTagWithPrefix()
    {
        $form = $this->getMockForAbstractClass(Form::class, array(null, null, "prefix"));
        $field = new CharField(array("label" => "Label"));
        $bound = new BoundField($form, $field, "name");
        $expected = '<label for="id_prefix-name">Label</label>';
        $this->assertXmlStringEqualsXmlString($bound->labelTag(), $expected);
    }

    public function testLabelTagWithContent()
    {
        $bound = new BoundField($this->simple_form, $this->simple_field, "name");
        $expected = '<label for="id_name">content</label>';
        $this->assertXmlStringEqualsXmlString($bound->labelTag("content"), $expected);
    }

    public function testLabelTagWithAttrs()
    {
        $bound = new BoundField($this->simple_form, $this->simple_field, "name");
        $attrs = array("class" => "show");

        $expected = '<label for="id_name" class="show">content</label>';
        $this->assertXmlStringEqualsXmlString($bound->labelTag("content", $attrs), $expected);
    }
}
