<?php
/**
 * DateTimeField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\DateTimeInput;

class DateTimeField extends TemporalField
{
    const FORMAT = "!d-m-Y H:i";

    protected $widget = DateTimeInput::class;

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->error_messages['invalid'] = msg("INVALID_DATETIME");
    }
}
