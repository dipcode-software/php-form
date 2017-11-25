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
    protected $format = 'd/m/Y H:i';
}
