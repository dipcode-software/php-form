<?php
/**
 * FileField Class
 */
namespace PHPForm\Fields;

use PHPForm\Exceptions\ValidationError;
use PHPForm\Validators\FileTypeValidator;
use PHPForm\Widgets\FileInput;

class FileField extends Field
{
    protected $widget = FileInput::class;

    /**
     * Constructor with extra args min_length and max_length
     *
     * @param array
     */
    public function __construct(array $args = array())
    {
        $this->max_size = array_key_exists('max_size', $args) ? $args['max_size'] : null;
        $this->valid_filetypes = array_key_exists('valid_filetypes', $args) ? $args['valid_filetypes'] : null;

        parent::__construct($args);

        if (!is_null($this->valid_filetypes)) {
            $this->validators[] = new FileTypeValidator($this->valid_filetypes);
        }
    }

    public function validate($value)
    {
        if (0 == $value->size && !$this->required) {
            return;
        }

        if (0 == $value->size && $this->required) {
            throw new ValidationError($this->error_messages['required'], 'required');
        }

        if (0 == $value->size) {
            throw new ValidationError(msg("EMPTY_FILE"), 'empty_file');
        }

        if (!is_null($this->max_size) && $value->size >= $this->max_size) {
            $message = msg("INVALID_FILE_MAX_SIZE", array(
                "limit" => $this->max_size,
                "value" => $value->size
            ));

            throw new ValidationError($message, 'max_size');
        }
    }

    public function toNative($value)
    {
        if (!is_array($value)) {
            throw new ValidationError(msg("INVALID_FILE"), 'invalid');
        }

        return (object) $value;
    }
}
