<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class DateTimeInput extends TemporalInput
{
    /**
    * @var string Format of temporal value.
    */
    const FORMAT = 'd-m-Y H:i';
}
