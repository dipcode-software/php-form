<?php
/**
* Base class for Messages definition
*/
namespace PHPForm;

use Fleshgrinder\Core\Formatter;

class Messages
{
    /**
     * @var array Default messages
     */
    private static $messages = array(
        "REQUIRED" => 'This field is required.',
        "INVALID_CHOICE" => 'Select a valid choice. "{choice}" is not one of the available choices.',
        "INVALID_LIST" => 'Enter a list of values.',
        "INVALID_DATE" => 'Enter a valid date.',
        "INVALID_DATETIME" => 'Enter a valid date/time.',
        "INVALID_NUMBER" => 'Enter a whole number.',
        "INVALID_EMAIL" => 'Enter a valid email address.',
        "INVALID_URL" => 'Enter a valid URL.',
        "INVALID_FILE" => 'Invalid file submitted.',
        "EMPTY_FILE" => 'The submitted file is empty.',
        "INVALID_FILE_MAX_SIZE" => 'Ensure the file has at most {limit} bytes (it has {value} bytes).',
        "INVALID_FILE_TYPE" => 'Ensure the file is one of "{valid_types}" types (it has {type}).',
        "INVALID_MAX_LENGTH" => 'Ensure this value has at most {limit} character (it has {value}).',
        "INVALID_MAX_VALUE" => 'Ensure this value is less than or equal to {limit}.',
        "INVALID_MIN_LENGTH" => 'Ensure this value has at least {limit} character (it has {value}).',
        "INVALID_MIN_VALUE" => 'Ensure this value is greater than or equal to {limit}.'
    );

    public static function setMessages(array $messages)
    {
        self::$messages = array_merge(self::$messages, $messages);
    }

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
        $message = array_key_exists($id, self::$messages) ? self::$messages[$id] : $id;

        if (!is_null($context)) {
            $message = Formatter::format($message, $context);
        }

        return $message;
    }
}
