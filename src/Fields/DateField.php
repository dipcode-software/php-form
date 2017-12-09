<?php
/**
 * DateField Class
 */
namespace PHPForm\Fields;

use PHPForm\Widgets\DateInput;

class DateField extends TemporalField
{
    const FORMAT = "!d-m-Y";

    protected $widget = DateInput::class;

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->error_messages['invalid'] = msg("INVALID_DATE");
    }
}
