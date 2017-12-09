<?php
/**
* Abstract class for renderers definition
*/
namespace PHPForm\Renderers;

abstract class Renderer
{
    abstract public function getTemplate($template_name);
    abstract public function render($template_name, $context);
}
