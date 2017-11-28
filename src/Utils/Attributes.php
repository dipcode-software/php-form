<?php
/**
 * Attributes utility
 */
namespace PHPForm\Utils;

use Fleshgrinder\Core\Formatter;

class Attributes
{
    public static function flatatt($attrs)
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

    public static function prettyName($name)
    {
        return ucfirst(str_replace("_", " ", $name));
    }

    public static function snakeToCamel($name)
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
    }
}
