<?php
/**
 * Validator to check if $value is an valid email
 */
namespace PHPForm\Validators;

use Fleshgrinder\Core\Formatter;

use PHPForm\Exceptions\ValidationError;
use PHPForm\PHPFormConfig;
use PHPForm\Validators\Validator;

class FileTypeValidator extends Validator
{
    protected $code = "invalid_file_type";

    public function __construct(array $valid_filetypes, $message = null)
    {
        $this->valid_filetypes = $valid_filetypes;

        if (is_null($message)) {
            $message = PHPFormConfig::getIMessage("INVALID_FILE_TYPE");
        }

        parent::__construct($message);
    }

    public function __invoke($value)
    {
        if (!is_null($this->valid_filetypes) && !in_array($value->type, $this->valid_filetypes)) {
            $message = Formatter::format($this->message, array(
                "valid_types" => implode(", ", $this->valid_filetypes),
                "type" => $value->type
            ));

            throw new ValidationError($message, 'invalid_file_type');
        }
    }
}
