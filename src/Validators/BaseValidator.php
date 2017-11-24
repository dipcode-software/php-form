<?php
/**
 * Validator to check if $value has max length
 */
namespace PHPForm\Validators;

use Fleshgrinder\Core\Formatter;

use PHPForm\Validators\Validator;
use PHPForm\Exceptions\ValidationError;

abstract class BaseValidator implements Validator
{
    /*
    * Receive a limit and can redefine message
    */
    public function __construct(int $value, $message = null)
    {
        $this->value = $value;

        if (isset($message)) {
            $this->message = $message;
        }
    }

    public function __invoke($value)
    {
        $cleaned = $this->cleanValue($value);

        if ($this->compare($cleaned, $this->value)) {
            $message = Formatter::format($this->message, array(
                "limit" => $this->value,
                "value" => $cleaned
            ));
            throw new ValidationError($message, $this->code);
        }
    }

    protected function cleanValue($value)
    {
        return $value;
    }

    abstract protected function compare($a, $b);
}
