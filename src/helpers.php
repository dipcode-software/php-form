<?php

function prettyName($name)
{
    return ucfirst(str_replace("_", " ", $name));
}

function snakeToCamel($name)
{
    return str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
}
