<?php
/**
 * IntegerField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\MinLengthValidator;
use PHPForm\Validators\MaxLengthValidator;
use PHPForm\Widgets\NumberInput;

class IntegerField extends Field
{
    protected $widget = NumberInput::class;

    protected $error_messages = array(
        'invalid' => 'Enter a whole number.'
    );

    /**
    * @var int Max value.
    */
    private $max_value;

    /**
    * @var int Min value.
    */
    private $min_value;


    public function __construct(array $args = array())
    {
        parent::__construct($args);

        if (isset($this->min_value)) {
            $this->validators[] = new MinValueValidator($this->min_value);
        }
        if (isset($this->max_value)) {
            $this->validators[] = new MaxValueValidator($this->max_value);
        }
    }

    public function toNative($value)
    {
        if (is_numeric($value)) {
            return intval($value);
        } else {
            throw new ValidationError($this->error_messages['invalid'], 'invalid');
        }
    }

    public function widgetAttrs($widget)
    {
        $attrs = parent::widgetAttrs($widget);

        if (isset($this->min_value) && !is_null($this->min_value)) {
            $attrs['min'] = $this->min_value;
        }
        if (isset($this->max_value) && !is_null($this->max_value)) {
            $attrs['max'] = $this->max_value;
        }

        return $attrs;
    }
}
