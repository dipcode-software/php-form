<?php
namespace PHPForm\Bounds;

use PHPForm\Config;

class BoundWidget
{
    private $data;
    private $template;

    public $for;
    public $type;
    public $name;
    public $value;
    public $label;

    public function __construct(array $data)
    {
        $this->for = $data["for"];
        $this->type = $data["type"];
        $this->name = $data["name"];
        $this->value = $data["value"];
        $this->label = $data["label"];
        $this->template = $data["template"];

        unset($data["template"]);

        $this->data = $data;
    }

    public function __toString()
    {
        $renderer = Config::getInstance()->getRenderer();

        return $renderer->render($this->template, $this->data);
    }
}
