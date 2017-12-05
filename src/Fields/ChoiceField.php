<?php
/**
 * ChoiceField Class
 */
namespace PHPForm\Fields;

use Fleshgrinder\Core\Formatter;

use PHPForm\Exceptions\ValidationError;
use PHPForm\PHPFormConfig;
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
            $error_message = PHPFormConfig::getIMessage("INVALID_CHOICE");
            $message = Formatter::format($error_message, array(
                'choice' => $value
            ));

            throw new ValidationError($message, 'invalid');
        }
    }
}
