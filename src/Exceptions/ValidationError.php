<?php
/**
 * Define a ValidationError exception class to be used to throw error on forms and fields
 */
namespace PHPForm\Exceptions;

class ValidationError extends \Exception
{
    /**
    * @var string Error message code.
    */
    private $message_code;

    /**
    * @var string List of errors.
    */
    private $error_list = array();

    /**
     * Redefine the exception so message isn't optional
     *
     * @param mixed
     * @param string|null
     */
    public function __construct($message, string $code = null)
    {

        if (is_array($message)) {
            $this->error_list = $message;
            // original constructor only accept string messages
            $message = "";
        } else {
            $this->error_list[] = $message;
        }

        $this->message_code = $code;

        parent::__construct($message, 0);
    }

    /**
    * Return error code
    *
    * @return string
    */
    public function getMessageCode()
    {
        return $this->message_code;
    }

    /**
    * Return list of errors
    *
    * @return array
    */
    public function getErrorList()
    {
        return $this->error_list;
    }
}
