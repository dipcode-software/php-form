# Getting started

## Instalation
PHPForm can be installed using Composer. Just add `dipcode/php-form` to you composer file like so:

```bash
$ composer require dipcode/php-form
```

## Usage
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
}
```

Define the template and render the form fields including label tags and error list:
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
<?php
namespace MyViews;

use MyForms\ContactForm;

public function handleForm()
{
    if (!empty($_POST)) {
        $form = new ContactForm(["data" => $_POST]);

        if ($form->isValid()) {
            // Form is valid, do your logic here
        }

        return $form;
    }

    return new ContactForm();
}
```

## Configurations
PHPForm can be configured through `PHPForm\Config` class singleton, allowing you to extend or override default configurations.

### Messages
To override PHPForm default messages, you will need to define and provide you own class.

For instance, the most common case is to make messages to translatable. Simply extend the original class `PHPForm\Messages` and redefine constants:

```php
<?php
namespace MyOwnNamespace;

use PHPForm\Messages;

class MyMessages extends Messages
{
    const REQUIRED = __('This field is required.');
    const INVALID_CHOICE = __('Select a valid choice. "{choice}" is not one of the available choices.');
    const INVALID_LIST = __('Enter a list of values.');
    const INVALID_DATE = __('Enter a valid date.');
    const INVALID_DATETIME = __('Enter a valid date/time.');
    const INVALID_NUMBER = __('Enter a whole number.');
    const INVALID_EMAIL = __('Enter a valid email address.');
    const INVALID_URL = __('Enter a valid URL.');
    const INVALID_FILE = __('Invalid file submitted.');
    const EMPTY_FILE = __('The submitted file is empty.');
    const INVALID_FILE_MAX_SIZE = __('Ensure the file has at most {limit} bytes (it has {value} bytes).');
    const INVALID_FILE_TYPE = __('Ensure the file is one of "{valid_types}" types (it has {type}).');
    const INVALID_MAX_LENGTH = __('Ensure this value has at most {limit} character (it has {value}).');
    const INVALID_MAX_VALUE = __('Ensure this value is less than or equal to {limit}.');
    const INVALID_MIN_LENGTH = __('Ensure this value has at least {limit} character (it has {value}).');
    const INVALID_MIN_VALUE = __('Ensure this value is greater than or equal to {limit}.');
}
```

Now we just need to set `PHPForm\Config` to use our new created class:
```php
<?php
namespace MyOwnNamespace;

use PHPForm\Config;

Config->getInstance()->setMessages(MyMessages::class);
```

### Template Packs

### Renderer
