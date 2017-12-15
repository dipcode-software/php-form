# Fields
The fields available to construct the `Form` class are described in this page.
Each field can has custom data formating and validation.

Field **attributes** must be passed based in an array:
```php
<?php
use PHPForm\Fields\CharField;

new CharField(["label" => "Name", required => true]);
```

## Core attributes
All fields available takes at least this attributes.

### `string $widget`
Define which `Widget` class will be used to render the field. See [widgets](widgets.md) for more info.

### `string $label`
Human-friendly label used when displaying the field.

The default value is calculated based on the field name, transforming underscores into spaces and upper-casing the first letter.

### `string $help_text`


### `bool $required`
By default, the field assumes the value is not required. To make it required, you need to define it as true explicitly.

When is required, calling `clean()` with empty value will throw a `ValidationError` exception.

```php
<?php
use PHPForm\Fields\CharField;

$field = new CharField(["required" => true]);

// all this examples will throw:
// PHPForm\Exceptions\ValidationError: This field is required.
$field->clean("");
$field->clean(" ");
$field->clean(null);
$field->clean(false);
$field->clean(0);

// all this examples not
echo $field->clean("value"); // "value"
echo $field->clean(1);       // "1"
```

!!! info "empty"
    [empty](http://php.net/manual/en/function.empty.php) php function used to check *emptiness*.

### `bool $disabled`
### `mixed $initial`
### `array $validators`
### `array $widget_attrs`
### `array $error_messages`

## BooleanField

## CharField
### `int $min_length`
### `int $max_length`

## ChoiceField
### `array $choices`

## DateField
### `string $format`

## DateTimeField
### `string $format`

## EmailField

## FileField
### `int $max_size`
### `array $valid_filetypes`

## IntegerField
### `int $min_value`
### `int $max_value`

## MultipleChoiceField
### `array $choices`

## URLField
