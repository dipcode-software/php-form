<?php
/**
* Base class for Messages definition
*/
namespace PHPForm;

use Fleshgrinder\Core\Formatter;

class Messages
{
    const REQUIRED = 'This field is required.';
    const INVALID_CHOICE = 'Select a valid choice. "{choice}" is not one of the available choices.';
    const INVALID_LIST = 'Enter a list of values.';
    const INVALID_DATE = 'Enter a valid date.';
    const INVALID_DATETIME = 'Enter a valid date/time.';
    const INVALID_NUMBER = 'Enter a whole number.';
    const INVALID_EMAIL = 'Enter a valid email address.';
    const INVALID_URL = 'Enter a valid URL.';
    const INVALID_FILE = 'Invalid file submitted.';
    const EMPTY_FILE = 'The submitted file is empty.';
    const INVALID_FILE_MAX_SIZE = 'Ensure the file has at most {limit} bytes (it has {value} bytes).';
    const INVALID_FILE_TYPE = 'Ensure the file is one of "{valid_types}" types (it has {type}).';
    const INVALID_MAX_LENGTH = 'Ensure this value has at most {limit} character (it has {value}).';
    const INVALID_MAX_VALUE = 'Ensure this value is less than or equal to {limit}.';
    const INVALID_MIN_LENGTH = 'Ensure this value has at least {limit} character (it has {value}).';
    const INVALID_MIN_VALUE = 'Ensure this value is greater than or equal to {limit}.';

    /**
     * Format message witg context.
     *
     * @param  string     $id      Const name or string to be formated.
     * @param  array|null $context Context to be passed to formater.
     *
     * @return string              Formated string.
     */
    public static function format(string $id, array $context = null)
    {
        $message = defined("static::$id") ? constant("static::$id") : $id;

        if (!is_null($context)) {
            $message = Formatter::format($message, $context);
        }

        return $message;
    }
}
