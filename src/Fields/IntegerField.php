<?php
/**
 * IntegerField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\MinValueValidator;
use PHPForm\Validators\MaxValueValidator;
use PHPForm\Widgets\NumberInput;

class IntegerField extends Field
{
    protected $widget = NumberInput::class;

    public function __construct(array $args = array())
    {
        $this->min_value = array_key_exists('min_value', $args) ? $args['min_value'] : null;
        $this->max_value = array_key_exists('max_value', $args) ? $args['max_value'] : null;

        parent::__construct($args);

        if (!is_null($this->min_value)) {
            $this->validators[] = new MinValueValidator($this->min_value);
        }
        if (!is_null($this->max_value)) {
            $this->validators[] = new MaxValueValidator($this->max_value);
        }
    }

    public function toNative($value)
    {
        $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        if (is_numeric($value)) {
            return intval($value);
        } else {
            throw new ValidationError(msg("INVALID_NUMBER"), 'invalid');
        }
    }

    public function widgetAttrs($widget)
    {
        $attrs = parent::widgetAttrs($widget);

        if (!is_null($this->min_value)) {
            $attrs['min'] = $this->min_value;
        }
        if (!is_null($this->max_value)) {
            $attrs['max'] = $this->max_value;
        }

        return $attrs;
    }
}
