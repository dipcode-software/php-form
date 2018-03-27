<?php
/**
*
*/
namespace PHPForm\Renderers;

use Twig\Loader\ChainLoader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

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
    public function __construct(array $templates_dirs, array $options = array())
    {
        $loaders = new ChainLoader();

        /* To maintain compatibility with non-PSR4 versions of Twig */
        if (class_exists('Twig_Loader_Filesystem')) {
            $class = 'Twig_Loader_Filesystem';
            $envClass = 'Twig_Environment';
        } else {
            $class = 'FilesystemLoader';
            $envClass = 'Environment';
        }

        foreach ($templates_dirs as $template_dir) {
            $loaders->addLoader(new $class($template_dir));
        }

        $this->twig = new $envClass($loaders, $options);
        $this->setFilters();
    }

    public function setFilters()
    {
        /* To maintain compatibility with non-PSR4 versions of Twig */
        if (class_exists('Twig_SimpleFilter')) {
            $class = 'Twig_SimpleFilter';
        } else {
            $class = 'TwigFilter';
        }

        $filter_merge_str = new $class('merge_str', function ($attrs, array $options = array()) {
            $key = $options[0];
            $value = $options[1];

            if (array_key_exists($key, $attrs)) {
                $attrs[$key] = implode(' ', [$value, $attrs[$key]]);
            } else {
                $attrs[$key] = $value;
            }

            return $attrs;
        }, array('is_variadic' => true));

        $this->twig->addFilter($filter_merge_str);
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
