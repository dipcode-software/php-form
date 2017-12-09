<?php
namespace PHPForm;

use PHPForm\Renderers\TwigRenderer;

class Config extends Singleton
{
    /**
     * @var string Directory with templates
     */
    protected $templates_dir = __DIR__ . '/templates/';

    /**
     * @var string Default fallback template pack
     */
    protected $fallback_template_pack = "default";

    /**
     * @var string Default template pack defined. If null, fallback is used.
     */
    protected $template_pack = null;

    /**
     * @var string Renderer class used to render html content
     */
    protected $renderer_class = TwigRenderer::class;

    /**
     * @var PHPForm\Renderers\Renderer Renderer instance based on $renderer_class.
     */
    private $renderer;

    /**
     * Templates path accordingly with defined template pack.
     *
     * @return string
     */
    private function buildPath($template_pack)
    {
        $path = $this->templates_dir . $template_pack . "/";

        if (!file_exists($path)) {
            trigger_error("Template pack dir '$path' don't exists.", E_USER_ERROR);
        }

        return $path;
    }

    /**
     * Return renderer class instantiated
     *
     * @return PHPForm\Renderers\Renderer
     */
    public function getRenderer()
    {
        if (is_null($this->renderer)) {
            $fallback_pack_dir = $this->buildPath($this->fallback_template_pack);
            $pack_dir = !is_null($this->template_pack) ? $this->buildPath($this->template_pack) : null;

            $this->renderer = new $this->renderer_class($fallback_pack_dir, $pack_dir);
        }

        return $this->renderer;
    }

    /**
     * Define template pack
     *
     * @param string
     */
    public function setTemplatePack($template_pack)
    {
        $this->template_pack = $template_pack;
    }
}
