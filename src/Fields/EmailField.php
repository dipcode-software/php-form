<?php
/**
 * EmailField Class
 */
namespace PHPForm\Fields;

use PHPForm\Validators\EmailValidator;
use PHPForm\Widgets\EmailInput;

class EmailField extends CharField
{
    protected $widget = EmailInput::class;

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->validators[] = new EmailValidator();
    }

    public function toNative($value)
    {
        $value = parent::toNative($value);

        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
}
