<?php
/**
*
*/
namespace PHPForm\Renderers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Loader\ChainLoader;

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
        $loaders = new ChainLoader();

        foreach ($templates_dirs as $template_dir) {
            $loaders->addLoader(new FilesystemLoader($template_dir));
        }

        $this->twig = new Environment($loaders);
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
