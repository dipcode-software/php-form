<?php
namespace PHPForm\Unit\Forms;

use PHPForm\Forms\Form;
use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\CharField;
use PHPForm\Fields\EmailField;
use PHPForm\Widgets\Textarea;

class ExampleForm extends Form
{
    protected $css_classes = array("form-control");

    protected static function setFields()
    {
        return array(
            "title" => new CharField(["required" => true]),
            "description" => new CharField(["widget" => Textarea::class, "max_length" => 10]),
            "email" => new EmailField(),
            "disabled" => new CharField(["disabled" => true]),
        );
    }

    protected function clean()
    {
        $cleaned_data = parent::clean();

        if (isset($cleaned_data['title']) && $cleaned_data['title'] == "Title") {
            $this->addError("Error on title", "title");
        }

        if (isset($cleaned_data['title']) && $cleaned_data['title'] == "Title2") {
            $this->addError("Error on title 1", "title");
            $this->addError("Error on title 2", "title");
        }

        if (isset($cleaned_data['title']) && isset($cleaned_data['description']) &&
                $cleaned_data['title'] == $cleaned_data['description']) {
            $this->addError("Title and description can't be equal");
        }

        if (isset($cleaned_data['email']) && $cleaned_data['email'] == "test@unit.c") {
            throw new ValidationError("Email invalid");
        }

        return $cleaned_data;
    }

    protected function cleanEmail()
    {
        $email = isset($this->cleaned_data['email']) ? $this->cleaned_data['email'] : null;

        if ($email == "test2@unit.c") {
            throw new ValidationError("Error Processing Email");
        }

        return $email;
    }
}
