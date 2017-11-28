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
     * Constructor with extra args min_length and max_length
     *
     * @param array
     */
    public function __construct(array $args = array())
    {
        $this->min_length = array_key_exists('min_length', $args) ? $args['min_length'] : null;
        $this->max_length = array_key_exists('max_length', $args) ? $args['max_length'] : null;

        parent::__construct($args);

        if (!is_null($this->min_length)) {
            $this->validators[] = new MinLengthValidator($this->min_length);
        }
        if (!is_null($this->max_length)) {
            $this->validators[] = new MaxLengthValidator($this->max_length);
        }
    }

    /**
     * Return extra minlength and maxlength attrs to be added to the input in HTML.
     *
     * @param  PHPForm\Widgets\Widget
     * @return array
     */
    public function widgetAttrs($widget)
    {
        $attrs = parent::widgetAttrs($widget);

        if (!is_null($this->min_length)) {
            $attrs['minlength'] = $this->min_length;
        }
        if (!is_null($this->max_length)) {
            $attrs['maxlength'] = $this->max_length;
        }

        return $attrs;
    }
}
