<?php
/**
* Abstract class for renderers definition
*/
namespace PHPForm\Renderers;

interface Renderer
{
    public function __construct(array $templates_dirs);
    public function render(string $template_name, array $context);
}
