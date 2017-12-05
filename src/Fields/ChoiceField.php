<?php
/**
 * ChoiceField Class
 */
namespace PHPForm\Fields;

use Fleshgrinder\Core\Formatter;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Widgets\Select;

class ChoiceField extends Field
{
    protected $widget = Select::class;
    protected $choices = array();

    protected $error_messages = array(
        'invalid' => 'Select a valid choice. "{choice}" is not one of the available choices.'
    );

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $choices = array_key_exists('choices', $args) ? $args['choices'] : array();

        $this->setChoices($choices);
    }

    public function setChoices(array $choices)
    {
        $this->choices = $choices;
        $this->widget->setChoices($choices);
    }

    public function isEmpty($value)
    {
        return empty($value) && $value != "0";
    }

    public function toNative($value)
    {
        return !$this->isEmpty($value) ? (string) $value : '';
    }

    public function validate($value)
    {
        parent::validate($value);

        if ($this->isEmpty($value) || !array_key_exists($value, $this->choices)) {
            $message = Formatter::format($this->error_messages['invalid'], array(
                'choice' => $value
            ));

            throw new ValidationError($message, 'invalid');
        }
    }
}
