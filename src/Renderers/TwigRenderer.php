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
    /**
     * @var Twig_Environment Twig instance.
     */
    private $twig;

    /**
     * Instantiate twig and chain loaders. The chain loader will start from the
     * first element in the array to load templates, traversing the array until
     * it finds the template.
     *
     * @param array $template_dirs
     */
    public function __construct(array $templates_dirs)
    {
        $loaders = new Twig_Loader_Chain();

        foreach ($templates_dirs as $template_dir) {
            $loaders->addLoader(new Twig_Loader_Filesystem($template_dir));
        }

        $this->twig = new Twig_Environment($loaders);
    }

    /**
     * @param  string $template_name Template path to be loaded.
     *
     * @return Twig_TemplateWrapper
     */
    private function getTemplate(string $template_name)
    {
        return $this->twig->load($template_name);
    }

    /**
     * @param  string $template_name Template path to be loaded.
     * @param  array  $context       Data to be injected on template.
     *
     * @return string
     */
    public function render(string $template_name, array $context)
    {
        $template = $this->getTemplate($template_name);
        return $template->render($context);
    }
}
