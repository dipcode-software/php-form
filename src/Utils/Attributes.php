<?php
/**
 * Attributes utility
 */
namespace PHPForm\Utils;

use Fleshgrinder\Core\Formatter;

class Attributes
{
    public static function flatten($attrs)
    {
        if (!is_array($attrs)) {
            return '';
        }

        $flat = [];

        foreach ($attrs as $name => $value) {
            $flat[] = Formatter::format('{name}="{value}"', array(
                "name" => $name,
                "value" => htmlentities($value)
            ));
        }

        return implode(" ", $flat);
    }
}
