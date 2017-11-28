<?php
namespace PHPForm\Forms;

use ArrayAccess;
use Iterator;
use Countable;

use Fleshgrinder\Core\Formatter;

use PHPForm\Errors\ErrorList;
use PHPForm\Exceptions\ValidationError;
use PHPForm\Fields\BoundField;
use PHPForm\Utils\Attributes;

abstract class Form implements ArrayAccess, Iterator, Countable
{
    const PREFIX_TEMPLATE = '{prefix}-{field_name}';
    const NON_FIELD_ERRORS = '__all__';

    private $form_errors = null;
    private $is_bound = false;
    protected $fields = array();
    protected $cleaned_data = array();

    public function __construct(array $data = null, array $files = null, string $prefix = null)
    {
        $this->is_bound = !is_null($data) or !is_null($files);
        $this->data = $data;
        $this->files = $files;
        $this->prefix = $prefix;
        $this->fields = $this::setFields();
    }

    /**
     * Method to be redefined with form fields
     *
     * @return array Desired fields for this form.
     */
    protected static function setFields()
    {
        return array();
    }

    public function isBound()
    {
        return $this->is_bound;
    }

    /**
     * Special method to make errors accessible as a attribute.
     *
     * @param  string Attribute name.
     *
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
     *
     * @param  string Field name.
     *
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
     * @param mixed
     * @param string
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
            $widget = $field->getWidget();
            $value = $widget->valueFromData($this->data, $this->files, $this->addPrefix($field_name));

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
     *
     * @return array Cleaned data
     */
    protected function clean()
    {
        return $this->cleaned_data;
    }

    /**
     * @param  string Field name
     * @return ErrorList
     */
    public function getFieldErrors(string $field_name)
    {
        if (!array_key_exists($field_name, $this->errors)) {
            return new ErrorList();
        }

        return $this->errors[$field_name];
    }

    /**
     * Return errors not associated with any field.
     *
     * @return ErrorList
     */
    public function getNonFieldErrors()
    {
        if (!array_key_exists($this::NON_FIELD_ERRORS, $this->errors)) {
            return new ErrorList();
        }

        return $this->errors[$this::NON_FIELD_ERRORS];
    }

    /**
     * Check if form is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->is_bound and !count($this->errors);
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

    public function offsetGet($offset)
    {
        $field = isset($this->fields[$offset]) ? $this->fields[$offset] : null;
        return new BoundField($this, $field, $offset);
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
