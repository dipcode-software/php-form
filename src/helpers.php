<?php

use PHPForm\Config;

function prettyName($name)
{
    return ucfirst(str_replace("_", " ", $name));
}

function snakeToCamel($name)
{
    return str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
}

function msg(string $id, array $context = null)
{
    $messages = Config::getInstance()->getMessages();
    return $messages::format($id, $context);
}
