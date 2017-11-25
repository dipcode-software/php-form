<?php
/**
 * Abstract Field Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;

abstract class Field
{
    /**
    * @var array Array of considered empty values.
    */
    const EMPTY_VALUES = array(null, '', []);

    /**
    * @var string Widget name.
    */
    protected $widget;

    /**
    * @var string Field name.
    */
    protected $name;

    /**
    * @var string Field nice name.
    */
    protected $label = null;

    /**
    * @var string Help text for this field.
    */
    protected $help_text;

    /**
    * @var bool Mark field as required.
    */
    protected $required = false;

    /**
    * @var mixed Field value.
    */
    protected $value;

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
        $this->computeArgs($args);

        if (!is_null($this->widget)) {
            $this->widget = new $this->widget;
            $this->widget->setRequired($this->required);
            $this->widget->setAttrs($this->widgetAttrs($this->widget));
        }

        $this->error_messages = array_merge($this::getErrorMessages(), $this->error_messages);
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
        if (in_array($value, $this::EMPTY_VALUES) && $this->required) {
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
        if (in_array($value, $this::EMPTY_VALUES)) {
            return;
        }

        $errors = array();

        foreach ($this->validators as $validator) {
            try {
                $validator($value);
            } catch (ValidationError $e) {
                if (array_key_exists($e->getCode(), $this->error_messages)) {
                    $errors[] = new ValidationError($this->error_messages[$e->getCode()], $e->getCode());
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
    public function getErrorMessages($class = null)
    {
        if (is_null($class)) {
            $class = get_class($this);
        }

        $class_vars = get_class_vars($class);
        $error_messages = $class_vars['error_messages'];

        if ($class == __CLASS__) {
            return $error_messages;
        }

        $parent = get_parent_class($class);

        $error_messages = array_merge(
            $this->getErrorMessages($parent),
            $error_messages
        );

        return $error_messages;
    }

    /**
    * Init object arguments, but only valid class arguments, otherwise throw an exception.
    *
    * @param array $args    Arguments to be setted.
    * @param array $exclude Fields to be excluded when trying to set value.
    *
    * @throws InvalidArgumentException
    */
    private function computeArgs(array $args = array(), array $exclude = array())
    {
        foreach ($args as $name => $value) {
            if (property_exists(__CLASS__, $name)) {
                if (!in_array($name, $exclude)) {
                    $this->$name = $value;
                }
            } else {
                throw new \InvalidArgumentException("Unexpected argument: '$name'");
            }
        }
    }
}
