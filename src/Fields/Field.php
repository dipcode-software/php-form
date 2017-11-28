<?php
/**
 * Abstract Field Class
 */
namespace PHPForm\Fields;

use InvalidArgumentException;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Utils\Attributes;

abstract class Field
{
    /**
    * @var string Widget name.
    */
    protected $widget;

    /**
    * @var string Field nice name.
    */
    protected $label = null;

    /**
    * @var string Help text for this field.
    */
    protected $help_text = '';

    /**
    * @var bool Mark field as required.
    */
    protected $required = false;

    /**
     * Initial value if no data bounded.
     * @var mixed
     */
    protected $initial = null;

    /**
    * @var array Array of user validators.
    */
    protected $validators = array();

    /**
    * @var array Array of message errors.
    */
    protected $error_messages = array(
        'required' => 'This field is required.'
    );

    /**
    * Instantiates a field.
    *
    * @param mixed  $widget           The class name or instance of the widget.
    * @param mixed  $label            The label to display.
    * @param mixed  $help_text        The help text to display.
    * @param bool   $required         A flag indicating whether a field is required.
    * @param array  $validators       An array of validators.
    * @param array  $error_messages   An array of error messages.
    *
    * @return null
    */
    public function __construct(array $args = array())
    {
        $this->widget = array_key_exists('widget', $args) ? $args['widget'] : $this->widget;
        $this->label = array_key_exists('label', $args) ? $args['label'] : $this->label;
        $this->help_text = array_key_exists('help_text', $args) ? $args['help_text'] : $this->help_text;
        $this->required = array_key_exists('required', $args) ? $args['required'] : $this->required;
        $this->initial = array_key_exists('initial', $args) ? $args['initial'] : $this->initial;
        $this->validators = array_key_exists('validators', $args) ? $args['validators'] : $this->validators;
        $this->error_messages = array_key_exists('error_messages', $args) ?
            $args['error_messages'] : $this->error_messages;

        if (!is_null($this->widget)) {
            $this->widget = new $this->widget;
            $this->widget->setRequired($this->required);
            $this->widget->setAttrs($this->widgetAttrs($this->widget));
        }

        $this->error_messages = array_merge($this->getErrorMessages(), $this->error_messages);
    }

    /**
    * Return defined widget.
    *
    * @return \PHPForm\Widgets\Widget
    */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
    * Return defined initial value.
    *
    * @return mixed
    */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
    * Return defined if this field is required or not.
    *
    * @return bool
    */
    public function isRequired()
    {
        return $this->required;
    }

    /**
    * Return defined label or construct one based on the field name.
    *
    * @param  string $name Name to be prettified, if no label defined.
    *
    * @return string
    */
    public function getLabel(string $name = null)
    {
        $label = $this->label;

        if (is_null($this->label) && !is_null($name)) {
            $label = Attributes::prettyName($name);
        }

        return $label;
    }

    /**
    * Return defined label or construct one based on the field name.
    *
    * @return string
    */
    public function getHelpText()
    {
        return $this->help_text;
    }

    /**
    * Tranforms $value into a native php object type.
    *
    * @param mixed $value Value to tranform.
    *
    * @return mixed
    */
    public function toNative($value)
    {
        return $value;
    }

    /**
    * Extra class specific $value validation
    *
    * @param mixed $value Value to validate.
    *
    * @throws ValidationError
    */
    public function validate($value)
    {
        if (empty($value) && $this->required) {
            throw new ValidationError($this->error_messages['required'], 'required');
        }
    }

    /**
    * Run all external validators through $value.
    *
    * @param mixed $value Value to validate.
    *
    * @throws ValidationError
    */
    public function runValidators($value)
    {
        if (empty($value)) {
            return;
        }

        $errors = array();

        foreach ($this->validators as $validator) {
            try {
                $validator($value);
            } catch (ValidationError $e) {
                if (array_key_exists($e->getMessageCode(), $this->error_messages)) {
                    $errors[] = $this->error_messages[$e->getMessageCode()];
                } else {
                    $errors[] = $e->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            throw new ValidationError($errors);
        }
    }

    /**
    * Run $value through all external and specific class validator
    *
    * @param mixed $value Value to clean.
    */
    public function clean($value)
    {
        $value = $this->toNative($value);
        $this->validate($value);
        $this->runValidators($value);

        return $value;
    }

    /**
    * Return attributes that should be added to the widget.
    *
    * @param mixed $widget Widget instance.
    */
    public function widgetAttrs($widget)
    {
        return array();
    }

    /**
     * Returns the combined inherited error messages for the field.
     *
     * @param string $class The class name to retrieve error message from.
     *
     * @return array
     */
    private function getErrorMessages($class = null)
    {
        if (is_null($class)) {
            $class = get_class($this);
        }

        $error_messages = array();

        do {
            $class_vars = get_class_vars($class);
            $error_messages = array_merge($class_vars['error_messages'], $error_messages);
        } while ($class = get_parent_class($class));

        return $error_messages;
    }
}
