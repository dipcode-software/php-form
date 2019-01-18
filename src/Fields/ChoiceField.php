<?php
/**
 * ChoiceField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Widgets\Select;

class ChoiceField extends Field
{
    protected $widget = Select::class;
    protected $choices = array();

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

    protected function isEmpty($value)
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

        if (!$this->isEmpty($value) && !$this->validValue($value)) {
            if (is_array($value)) {
                $value_diff = array_diff($value, array_keys($this->choices));
                $value = implode(', ', $value_diff);
            }

            $message = msg("INVALID_CHOICE", array(
                'choice' => $value,
            ));

            throw new ValidationError($message, 'invalid');
        }
    }

    protected function validValue($value)
    {
        return array_key_exists($value, $this->choices);
    }
}
