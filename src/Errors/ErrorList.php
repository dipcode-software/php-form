<?php
namespace PHPForm\Errors;

use ArrayObject;

use PHPForm\Config;

class ErrorList extends ArrayObject
{
    const TEMPLATE = "error_list.html";

    /**
     * Returns the error list rendered as HTML.
     *
     * @return string
     */
    public function __toString()
    {
        if (!count($this)) {
            return '';
        }

        $renderer = Config::getInstance()->getRenderer();

        return $renderer->render(self::TEMPLATE, array(
            "errors" => $this,
        ));
    }
}
