<?php
namespace PHPForm\Unit\Bounds;

use PHPUnit\Framework\TestCase;

use PHPForm\Bounds\BoundField;
use PHPForm\Bounds\BoundWidget;
use PHPForm\Errors\ErrorList;
use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\CharField;
use PHPForm\Fields\ChoiceField;
use PHPForm\Widgets\RadioSelect;
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
        $form = $this->getMockForAbstractClass(Form::class, array(["prefix" => "form"]));
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

    public function testGetHasErrors()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");

        $this->assertFalse($bound->has_errors);
    }

    public function testGetIsRequired()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");

        $this->assertFalse($bound->is_required);
    }

    public function testGetValue()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");

        $this->assertNull($bound->value);
    }

    public function testGetNotDefinedAttribute()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");

        $this->assertNull($bound->undefined);
    }

    public function testSimpleGet()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $bound = new BoundField($form, $this->simple_field, "name");
        $this->assertEquals($bound->label, "Name");
    }

    public function testToString()
    {
        $form_args = ["data" => ["name" => "value"]];
        $form = $this->getMockForAbstractClass(Form::class, array($form_args));

        $bound = new BoundField($form, $this->simple_field, "name");

        $expected = '<input type="text" id="id_name" name="name" value="value"/>';
        $this->assertXmlStringEqualsXmlString((string) $bound, $expected);
    }

    public function testToStringWithPrefix()
    {
        $form_args = ["data" => ["prefix-name" => "value"], "prefix" => "prefix"];
        $form = $this->getMockForAbstractClass(Form::class, array($form_args));

        $bound = new BoundField($form, $this->simple_field, "name");

        $expected = '<input type="text" id="id_prefix-name" name="prefix-name" value="value"/>';
        $this->assertXmlStringEqualsXmlString((string) $bound, $expected);
    }

    public function testToStringWithCssClasses()
    {
        $form_args = ["css_classes" => ["form-control", "form-control-sm"]];
        $form = $this->getMockForAbstractClass(Form::class, array($form_args));

        $bound = new BoundField($form, $this->simple_field, "name");

        $expected = '<input type="text" id="id_name" name="name" class="form-control form-control-sm"/>';
        $this->assertXmlStringEqualsXmlString($expected, (string) $bound);
    }

    public function testToStringWithErrors()
    {
        $form = $this->getMockBuilder(Form::class)
                ->setMethods(array('hasErrors'))
                ->getMockForAbstractClass();

        $form->method('hasErrors')
            ->will($this->returnValue(true));

        $field = new CharField(["required" => true]);
        $bound = new BoundField($form, $field, "name");

        $expected = '<input type="text" id="id_name" name="name" required="required" class="is-invalid"/>';

        $this->assertXmlStringEqualsXmlString($expected, (string) $bound);
    }

    public function testToStringWithFieldRequired()
    {
        $form = $this->getMockForAbstractClass(Form::class);
        $field = new CharField(['disabled' => true]);

        $bound = new BoundField($form, $field, "name");

        $expected = '<input type="text" id="id_name" name="name" disabled="disabled"/>';
        $this->assertXmlStringEqualsXmlString($expected, (string) $bound);
    }

    public function testLabelTag()
    {
        $field = new CharField(array("label" => "Label"));
        $bound = new BoundField($this->simple_form, $field, "name");

        $expected = '<label for="id_name">Label</label>';

        $this->assertXmlStringEqualsXmlString($bound->labelTag(), $expected);
        $this->assertXmlStringEqualsXmlString($bound->label_tag, $expected);
    }

    public function testLabelTagWithPrefix()
    {
        $form_args = ["prefix" => "prefix"];
        $form = $this->getMockForAbstractClass(Form::class, array($form_args));

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

    public function testLabelTagWithoutContent()
    {
        $field = new CharField(["label" => ""]);
        $bound = new BoundField($this->simple_form, $field, "name");

        $this->assertEquals($bound->labelTag(), "");
    }

    public function testLabelTagWithAttrs()
    {
        $bound = new BoundField($this->simple_form, $this->simple_field, "name");
        $attrs = array("class" => "show");

        $expected = '<label for="id_name" class="show">content</label>';
        $this->assertXmlStringEqualsXmlString($bound->labelTag("content", $attrs), $expected);
    }


    public function testOptions()
    {
        $field = new ChoiceField(["choices" => array("option1" => "Option1")]);
        $bound = new BoundField($this->simple_form, $field, "name");

        $this->assertInstanceOf(BoundWidget::class, $bound->options[0]);
    }
}
