<?php
/**
 * Abstract Field Class
 */
namespace PHPForm\Fields;

use InvalidArgumentException;

use PHPForm\Exceptions\ValidationError;
use PHPForm\PHPFormConfig;
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
    * @var bool Mark field as disabled.
    */
    protected $disabled = false;

    /**
     * Initial value if no data bounded.
     * @var mixed
     */
    protected $initial = null;

    /**
    * @var array Array of attributes to be added to widget.
    */
    protected $widget_attrs = array();

    /**
    * @var array Array of user validators.
    */
    protected $validators = array();

    /**
    * @var array Array of message errors.
    */
    protected $error_messages = array();

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
        $this->disabled = array_key_exists('disabled', $args) ? $args['disabled'] : $this->disabled;
        $this->initial = array_key_exists('initial', $args) ? $args['initial'] : $this->initial;
        $this->validators = array_key_exists('validators', $args) ? $args['validators'] : $this->validators;
        $this->widget_attrs = array_key_exists('widget_attrs', $args) ? $args['widget_attrs'] : $this->widget_attrs;
        $this->error_messages = array_key_exists('error_messages', $args) ?
            $args['error_messages'] : $this->error_messages;

        $default_error_messages = array(
            'required' => PHPFormConfig::getIMessage("REQUIRED"),
        );

        $this->error_messages = array_merge($default_error_messages, $this->error_messages);

        if (!is_null($this->widget)) {
            // instantiate widget class if string is passed like so: Widget::class
            if (is_string($this->widget)) {
                $this->widget = new $this->widget;
            }

            $this->widget->setAttrs($this->widgetAttrs($this->widget));
        }
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
    * Return defined if this field is disabled or not.
    *
    * @return bool
    */
    public function isDisabled()
    {
        return $this->disabled;
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
        return $this->widget_attrs;
    }
}
