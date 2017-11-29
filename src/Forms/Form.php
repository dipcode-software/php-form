<?php
namespace PHPForm\Forms;

use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;
use UnexpectedValueException;

use Fleshgrinder\Core\Formatter;

use PHPForm\Errors\ErrorList;
use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\BoundField;
use PHPForm\Utils\Attributes;

abstract class Form implements ArrayAccess, Iterator, Countable
{
    const PREFIX_TEMPLATE = '{prefix}-{field_name}';
    const NON_FIELD_ERRORS = '__all__';

    /**
     * List of form errors.
     * @var array
     */
    private $form_errors = null;

    /**
     * Array of bounded field to cache propose.
     * @var array
     */
    private $bound_fields_cache = array();

    /**
     * Indicates if there's data bounded to form.
     * @var boolean
     */
    private $is_bound = false;

    /**
     * Prefix to be used in form names.
     * @var string
     */
    protected $prefix = null;

    /**
     * Cass classes to be added to all widgets.
     * @var array
     */
    protected $css_classes = array();

    /**
     * Fields declared to this form.
     * @var array
     */
    protected $fields = array();

    /**
     * Cleaned values after validation.
     * @var array
     */
    protected $cleaned_data = array();

    /**
     * Constructor method
     * @param array $args Arguments
     */
    public function __construct(array $args = array())
    {
        $this->data = array_key_exists('data', $args) ? $args['data'] : null;
        $this->files = array_key_exists('files', $args) ? $args['files'] : null;
        $this->prefix = array_key_exists('prefix', $args) ? $args['prefix'] : $this->prefix;
        $this->initial = array_key_exists('initial', $args) ? $args['initial'] : array();
        $this->css_classes = array_key_exists('css_classes', $args) ? $args['css_classes'] : $this->css_classes;

        $this->is_bound = !is_null($this->data) or !is_null($this->files);
        $this->fields = $this::setFields();
    }

    /**
     * Method to be redefined with form fields
     * @return array Desired fields for this form.
     */
    protected static function setFields()
    {
        return array();
    }

    /**
     * Return if form is bounded or not.
     * @return boolean
     */
    public function isBound()
    {
        return $this->is_bound;
    }

    /**
     * Return css classes to be added to each widget.
     * @return array
     */
    public function getCssClasses()
    {
        return $this->css_classes;
    }

    /**
     * Special method to make errors accessible as a attribute.
     * @param  string $name Attribute name.
     * @return mixed
     */
    public function __get(string $name)
    {
        if ($name == 'errors') {
            if (is_null($this->form_errors)) {
                $this->fullClean();
            }

            return $this->form_errors;
        }

        return parent::__get($name);
    }

    /**
     * Add a prefix to a name.
     * @param  string $field_name Field name.
     * @return string
     */
    public function addPrefix(string $field_name)
    {
        if (!is_null($this->prefix)) {
            return Formatter::format(self::PREFIX_TEMPLATE, array(
                "prefix" => $this->prefix,
                "field_name" => $field_name
            ));
        }

        return $field_name;
    }

    /**
     * Add error to specific $field_name, if null, define to NON_FIELD_ERRORS.
     * @param mixed  $error
     * @param string $field_name
     */
    protected function addError($error, string $field_name = null)
    {
        $error = is_string($error) ? array($error) : $error;
        $field_name = is_null($field_name) ? $this::NON_FIELD_ERRORS : $field_name;

        if (array_key_exists($field_name, $this->form_errors)) {
            $this->form_errors[$field_name] = array_merge((array) $this->form_errors[$field_name], $error);
        } else {
            $this->form_errors[$field_name] = new ErrorList($error);
        }

        if (array_key_exists($field_name, $this->cleaned_data)) {
            unset($this->cleaned_data[$field_name]);
        }
    }

    /**
     * Validate fields and form
     */
    private function fullClean()
    {
        $this->form_errors = array();

        if (!$this->is_bound) {
            return;
        }

        $this->cleanFields();
        $this->cleanForm();
    }

    /**
     * Validate only fields and call form clean_[field] if existent.
     */
    private function cleanFields()
    {
        foreach ($this->fields as $field_name => $field) {
            if ($field->isDisabled()) {
                $value = $this->getInitialForField($field, $field_name);
            } else {
                $value = $field->getWidget()->valueFromData($this->data, $this->files, $this->addPrefix($field_name));
            }

            try {
                $this->cleaned_data[$field_name] = $field->clean($value);

                $method = 'clean' . Attributes::snakeToCamel($field_name);

                if (method_exists($this, $method)) {
                    $this->cleaned_data[$field_name] = call_user_func(array($this, $method));
                }
            } catch (ValidationError $e) {
                $this->addError($e->getErrorList(), $field_name);
            }
        }
    }

    /**
     * Validate form by calling clean method.
     */
    private function cleanForm()
    {
        try {
            $this->clean();
        } catch (ValidationError $e) {
            $this->addError($e->getErrorList());
        }
    }

    /**
     * Redefine if need to validate crossfields.
     * @return array Cleaned data
     */
    protected function clean()
    {
        return $this->cleaned_data;
    }

    /**
     * Return cleaned data values.
     * @return array Cleaned data
     */
    public function getCleanedData()
    {
        return $this->cleaned_data;
    }

    /**
     * Return cleaned field value.
     * @param  string $field_name Name of field.
     * @return string             Cleaned field value.
     */
    public function getCleanedField(string $field_name)
    {
        return isset($this->cleaned_data[$field_name]) ? $this->cleaned_data[$field_name] : null;
    }

    /**
     * Check if field has error on it.
     * @param  string   $field_name Name of field to check
     * @return boolean
     */
    public function hasError($field_name)
    {
        return array_key_exists($field_name, $this->errors);
    }

    /**
     * Return all errors associated to $field_name.
     * @param  string    $field_name Field name
     * @return ErrorList
     */
    public function getFieldErrors(string $field_name)
    {
        if (!$this->hasError($field_name)) {
            return new ErrorList();
        }

        return $this->errors[$field_name];
    }

    /**
     * Return errors not associated with any field.
     * @return ErrorList
     */
    public function getNonFieldErrors()
    {
        if (!$this->hasError($this::NON_FIELD_ERRORS)) {
            return new ErrorList();
        }

        return $this->errors[$this::NON_FIELD_ERRORS];
    }

    /**
     * Check if form is valid.
     * @return bool
     */
    public function isValid()
    {
        return $this->is_bound and !count($this->errors);
    }

    /**
     * Check if form is valid.
     * @return bool
     */
    public function getInitialForField($field, $field_name)
    {
        return isset($this->initial[$field_name]) ? $this->initial[$field_name] : $field->getInitial();
    }

    /**
     * Implementation of ArrayAccess interface to provide accessing objects as arrays.
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->fields[] = $value;
        } else {
            $this->fields[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->fields);
    }

    public function offsetUnset($offset)
    {
        unset($this->fields[$offset]);
    }

    /**
     * @throws UnexpectedValueException
     * @return BoundField
     */
    public function offsetGet($offset)
    {
        $field = isset($this->fields[$offset]) ? $this->fields[$offset] : null;

        if (is_null($field)) {
            $choices = implode(", ", array_keys($this->fields));
            $class_name = get_called_class();
            throw new UnexpectedValueException("Field '$offset' not found in $class_name. Choices are: $choices", 1);
        }

        if (!isset($this->bound_fields_cache[$offset])) {
            $this->bound_fields_cache[$offset] = new BoundField($this, $field, $offset);
        }

        return $this->bound_fields_cache[$offset];
    }

    /**
     * Implementation of Iterator interface for external iterators or
     * objects that can be iterated themselves internally.
     */
    public function rewind()
    {
        reset($this->fields);
    }

    public function current()
    {
        return current($this->fields);
    }

    public function key()
    {
        return key($this->fields);
    }

    public function next()
    {
        return next($this->fields);
    }

    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     * Implementation of Countable interface to be used with count function.
     */
    public function count()
    {
        return count($this->fields);
    }
}
