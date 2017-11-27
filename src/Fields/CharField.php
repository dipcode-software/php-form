<?php
/**
 * TextField Class
 */
namespace PHPForm\Fields;

use PHPForm\Validators\MinLengthValidator;
use PHPForm\Validators\MaxLengthValidator;
use PHPForm\Widgets\TextInput;

class CharField extends Field
{
    protected $widget = TextInput::class;

    /**
    * @var int Max value length.
    */
    protected $max_length;

    /**
    * @var int Min value length.
    */
    protected $min_length;

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        if (isset($this->min_length)) {
            $this->validators[] = new MinLengthValidator($this->min_length);
        }
        if (isset($this->max_length)) {
            $this->validators[] = new MaxLengthValidator($this->max_length);
        }
    }

    public function widgetAttrs($widget)
    {
        $attrs = parent::widgetAttrs($widget);

        if (isset($this->min_length) && !is_null($this->min_length)) {
            $attrs['minlength'] = $this->min_length;
        }
        if (isset($this->max_length) && !is_null($this->max_length)) {
            $attrs['maxlength'] = $this->max_length;
        }

        return $attrs;
    }
}
