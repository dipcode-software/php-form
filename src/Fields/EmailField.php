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
}
