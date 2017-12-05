# PHP Form
[![Build Status](https://travis-ci.org/dipcode-software/php-form.svg?branch=master)](https://travis-ci.org/dipcode-software/php-form)
[![Coverage Status](https://coveralls.io/repos/github/dipcode-software/php-form/badge.svg?branch=master)](https://coveralls.io/github/dipcode-software/php-form?branch=master)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](http://www.opensource.org/licenses/MIT)

PHP class for form handling abstraction inspired in Django Framework forms.

## Instalation
Library can be installed using Composer like so:

```shell
$ composer require dipcode/php-form
```

## Simple Example

Start by defining your form class like so:
```php
<?php
namespace MyForms;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\CharField;
use PHPForm\Fields\EmailField;
use PHPForm\Forms\Form;
use PHPForm\Widgets\Textarea;

class ContactForm extends Form
{
    protected static function setFields()
    {
        return array(
            'name' => new CharField(['required' => true]),
            'email' => new EmailField(['required' => true]),
            'subject' => new CharField(),
            'body' => new CharField(["widget" => Textarea::class])
        );
    }

    protected function clean()
    {
        // Use this function to crossfields validation
        //
        // You can use $this->addError($message, $field_name) to add error messages to specific fields.
        // Or just throw a ValidationError Exception.
    }
}
```

Define the template to render form fields:
```php
<form action="/contact-form/" method="POST" novalidate>
    <div class="form-row">
        <div class="col">
            <?php echo $form['name']->label_tag; ?>
            <?php echo $form['name']; ?>
            <?php echo $form['name']->errors; ?>
        </div>
        <div class="col">
            <?php echo $form['email']->label_tag; ?>
            <?php echo $form['email']; ?>
            <?php echo $form['email']->errors; ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <?php echo $form['subject']->label_tag; ?>
            <?php echo $form['subject']; ?>
            <?php echo $form['subject']->errors; ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <?php echo $form['body']->label_tag; ?>
            <?php echo $form['body']; ?>
            <?php echo $form['body']->errors; ?>
        </div>
    </div>

    <input type="submit" value="Submit">
</form>
```

Now process the form and force validation when `$_POST` data is sended:
```php
namespace MyViews;

use MyForms\ContactForm;

public function handleForm()
{
    if (!empty($_POST)) {
        $form = new ContactForm(["data" => $_POST]);

        if ($form->isValid()) {
            // Form is valid, do your logic here
            // Use can use $form->getCleanedData() to access cleaned and validated data.
        }

        return $form;
    }

    return new ContactForm();
}
```

## Available Fields

```php
// All fields has the following common arguments:
$args = [
    PHPForm\Widgets\Widget $widget,
    string $label = null,
    string $help_text = '',
    bool $required = false,
    bool $disabled = false,
    mixed $initial = null,
    array $validators = array(),
    array $widget_attrs = array(),
    array $error_messages = array()
]

// Fields available
// '...' represents common fields

new BooleanField([...]);
new CharField([int $max_length, int $min_length, ...]);
new ChoiceField([array $choices, ...]);
new DateField([string $format, ...]);
new DateTimeField([string $format, ...]);
new EmailField([...]);
new FileField([int $max_size, array $valid_filetypes, ...]);
new IntegerField([int $max_value, int $min_value, ...]);
new URLField([...]);

```

## Starting development
Start by cloning the repo:

```shell
$ git clone git@github.com:dipcode-software/php-form.git
$ cd php-form
```

Install the composer dependencies:
```shell
$ composer install
```

### Running the tests
To run tests, unit and style tests, just run:

```shell
$ composer test
```

### Coding Style

Largely PSR-2 compliant:

https://raw.githubusercontent.com/php-fig/fig-standards/master/accepted/PSR-2-coding-style-guide.md
