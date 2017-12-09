<?php
/**
* Abstract class for renderers definition
*/
namespace PHPForm\Renderers;

interface Renderer
{
    public function __construct(string $fallback_templates_dir, string $templates_dir);
    public function getTemplate(string $template_name);
    public function render(string $template_name, array $context);
}
