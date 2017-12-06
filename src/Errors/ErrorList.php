<?php
namespace PHPForm\Errors;

use ArrayObject;

use Fleshgrinder\Core\Formatter;

use PHPForm\PHPFormConfig;

class ErrorList extends ArrayObject
{
    /**
     * Returns the error list rendered as HTML.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->asUL();
    }

    /**
     * Returns an error dictionary as an unordered list in HTML.
     *
     * @return string
     */
    public function asUL()
    {
        if (!count($this)) {
            return '';
        }

        $items = [];
        $list_item_template = PHPFormConfig::getITemplate("ERRORLIST_ITEM");

        foreach ($this as $error) {
            $items[] = Formatter::format($list_item_template, array("content" => $error));
        }

        $list_template = PHPFormConfig::getITemplate("ERRORLIST");

        return Formatter::format($list_template, array("items" => implode($items)));
    }
}
