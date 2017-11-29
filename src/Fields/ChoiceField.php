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

    protected $error_messages = array(
        'invalid' => 'Select a valid choice. {choice} is not one of the available choices.'
    );

    public function __construct(array $args = array())
    {
        $this->choices = array_key_exists('choices', $args) ? $args['choices'] : array();

        parent::__construct($args);

        $this->widget->setChoices($this->choices);
    }

    public function toNative($value)
    {
        return !empty($value) ? (string) $value : '';
    }

    public function validate($value)
    {
        parent::validate($value);

        if (!array_key_exists($value, $this->choices)) {
            $message = Formatter::format($this->error_messages['invalid'], array(
                'choice' => $value
            ));

            throw new ValidationError($message, 'invalid');
        }
    }
}
