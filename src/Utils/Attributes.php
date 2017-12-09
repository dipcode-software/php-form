<?php
/**
 * Attributes utility
 */
namespace PHPForm\Utils;

class Attributes
{
    public static function prettyName($name)
    {
        return ucfirst(str_replace("_", " ", $name));
    }

    public static function snakeToCamel($name)
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
    }
}
