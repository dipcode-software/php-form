<?php
/**
 * Define a ValidationError exception class to be used to throw error on forms and fields
 */
namespace PHPForm\Exceptions;

class ValidationError extends \Exception
{
    /*
    * @var string Error message code.
    */
    private $message_code;

    /*
    * Redefine the exception so message isn't optional
    */
    public function __construct($message, string $code = null)
    {
        $this->message_code = $code;

        parent::__construct($message, 0);
    }

    /*
    * Return defined message code
    */
    public function getMessageCode()
    {
        return $this->message_code;
    }
}
