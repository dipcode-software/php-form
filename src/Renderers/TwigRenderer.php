<?php
/**
*
*/
namespace PHPForm\Renderers;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Loader_Chain;

class TwigRenderer implements Renderer
{
    private $twig;

    public function __construct(string $fallback_templates_dir, string $templates_dir = null)
    {
        $loaders = new Twig_Loader_Chain();

        if (!is_null($templates_dir)) {
            $loaders->addLoader(new Twig_Loader_Filesystem($templates_dir));
        }

        $loaders->addLoader(new Twig_Loader_Filesystem($fallback_templates_dir));

        $this->twig = new Twig_Environment($loaders);
    }

    public function getTemplate(string $template_name)
    {
        return $this->twig->load($template_name);
    }

    public function render(string $template_name, array $context)
    {
        $template = $this->getTemplate($template_name);
        return $template->render($context);
    }
}
