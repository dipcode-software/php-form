<?php
/**
 * BaseValidator to check $value through condition
 */
namespace PHPForm\Validators;

use Fleshgrinder\Core\Formatter;

use PHPForm\Validators\Validator;
use PHPForm\Exceptions\ValidationError;

abstract class BaseValidator extends Validator
{
    /*
    * Receive a limit and can redefine message
    */
    public function __construct(int $value, $message = null)
    {
        $this->value = $value;

        parent::__construct($message);
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
