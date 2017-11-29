<?php
/**
 * URLField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\URLValidator;
use PHPForm\Widgets\URLInput;

class URLField extends CharField
{
    protected $widget = URLInput::class;

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->validators[] = new URLValidator();
    }

    public function toNative($value)
    {
        $value = parent::toNative($value);

        return filter_var($value, FILTER_SANITIZE_URL);
    }
}
