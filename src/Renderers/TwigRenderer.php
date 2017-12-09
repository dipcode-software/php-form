<?php
/**
*
*/
namespace PHPForm\Renderers;

use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigRenderer extends Renderer
{
    private $loader;
    private $twig;

    public function __construct($templates_dir)
    {
        $this->loader = new Twig_Loader_Filesystem($templates_dir);
        $this->twig = new Twig_Environment($this->loader);
    }

    public function getTemplate($template_name)
    {
        return $this->twig->load($template_name);
    }

    public function render($template_name, $context)
    {
        $template = $this->getTemplate($template_name);
        return $template->render($context);
    }
}
