<?php
namespace PHPForm;

use PHPForm\Renderers\TwigRenderer;
use PHPForm\TemplatePacks\DefaultTemplatePack;

class Config extends Singleton
{
    /**
     * @var array Template packs to be used. The templates will be loaded
     *            accordingly to the order defined.
     */
    protected $template_packs = array(
        DefaultTemplatePack::class,
    );

    /**
     * @var string Renderer class used to render html content.
     */
    protected $renderer_class = TwigRenderer::class;

    /**
     * @var PHPForm\Renderers\Renderer Renderer instance based on $renderer_class.
     */
    private $renderer;

    /**
     * Return renderer class instantiated
     *
     * @return PHPForm\Renderers\Renderer
     */
    public function getRenderer()
    {
        if (is_null($this->renderer)) {
            $this->renderer = new $this->renderer_class($this->getTemplatesDirs());
        }

        return $this->renderer;
    }

    /**
     * Set renderer class.
     *
     * @param string Class name of Renderer.
     */
    public function setRenderer(string $renderer_class)
    {
        $this->renderer_class = $renderer_class;
    }

    /**
     * Set template pack on top level.
     *
     * @param string Class name of TemplatePack.
     */
    public function setTemplatePack(string $template_pack)
    {
        $this->template_packs = array_unshift($this->template_packs, $template_pack);
    }

    /**
     * Traverse all packs to extract template dir path.
     *
     * @return array
     */
    private function getTemplatesDirs()
    {
        $dirs = array();

        foreach ($this->template_packs as $template_pack) {
            $dirs[] = $template_pack::TEMPLATES_DIR;
        }

        return $dirs;
    }
}
