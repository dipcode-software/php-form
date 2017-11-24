<?php
/**
 * Abstract class for Widgets
 */
namespace PHPForm\Widgets;

class FileInput extends Input
{
    protected $input_type = 'file';

    /**
     * FileInput don't render the value.
     *
     * @param mixed $value Value to be formated.
     *
     * @return null
     */
    public function formatValue($value)
    {
        return null;
    }

    /**
     * Returns the value determined by the file and name.
     *
     * @param array $data   Array with form data.
     * @param array $files  Array with files form data.
     * @param name  $name   Name of field.
     *
     * @return mixed
     */
    public function valueFromData(array $data, array $files, string $name)
    {
        if (array_key_exists($name, $files)) {
            return $files[$name];
        }

        return null;
    }
}
