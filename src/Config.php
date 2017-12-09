<?php
namespace PHPForm;

use PHPForm\Renderers\TwigRenderer;

class Config extends Singleton
{
    /**
     * Template packs available
     */
    const TEMPLATE_PACKS = array("default", "bootstrap4");

    /**
     * Directory with templates
     * @var string
     */
    protected $templates_dir = __DIR__ . '/templates/';

    /**
     * Template pack defined
     * @var string
     */
    protected $template_pack = "default";

    /**
     * Renderer class used to render html content
     * @var string
     */
    protected $renderer_class = TwigRenderer::class;

    /**
     * Renderer instance based on $renderer_class.
     * @var PHPForm\Renderers\Renderer
     */
    private $renderer;

    /**
     * Templates path accordingly with defined template pack.
     * @return string
     */
    private function getTemplatesPath()
    {
        $path = $this->templates_dir . $this->template_pack . "/";

        if (!file_exists($path)) {
            trigger_error("Template dir '$path' don't exists.", E_USER_ERROR);
        }

        return $path;
    }

    /**
     * Return renderer class instantiated
     * @return PHPForm\Renderers\Renderer
     */
    public function getRenderer()
    {
        if (is_null($this->renderer)) {
            $this->renderer = new $this->renderer_class($this->getTemplatesPath());
        }

        return $this->renderer;
    }

    /**
     * Define template pack
     * @param string
     */
    public function setTemplatePack($template_pack)
    {
        if (!in_array($template_pack, self::TEMPLATE_PACKS)) {
            $packs = implode(", ", self::TEMPLATE_PACKS);
            trigger_error("Template pack '$template_pack' not valid. Available packs are: $packs", E_USER_ERROR);
        }

        $this->template_pack = $template_pack;
    }
}
