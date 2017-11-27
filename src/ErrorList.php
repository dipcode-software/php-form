<?php
namespace PHPForm;

use ArrayObject;

use Fleshgrinder\Core\Formatter;

class ErrorList extends ArrayObject
{
    const LIST_TEMPLATE = '<ul class="errorlist">{items}</ul>';
    const LIST_ITEM_TEMPLATE = '<li>{content}</li>';

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

        foreach ($this as $error) {
            $items[] = Formatter::format($this::LIST_ITEM_TEMPLATE, array("content" => $error));
        }

        return Formatter::format($this::LIST_TEMPLATE, array("items" => impode($items)));
    }
}
