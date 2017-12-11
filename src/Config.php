<?php
namespace PHPForm;

use PHPForm\Renderers\TwigRenderer;
use PHPForm\TemplatePacks\DefaultTemplatePack;
use PHPForm\Messages;

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
    protected $messages_class = Messages::class;

    /**
     * @var string Renderer class used to render html content.
     */
    protected $renderer_class = TwigRenderer::class;

    /**
     * @var PHPForm\Renderers\Renderer Renderer instance based on $renderer_class.
     */
    private $renderer;

    /**
     * Set template pack on top level.
     *
     * @param string Class name of TemplatePack.
     */
    public function setTemplatePack(string $template_pack)
    {
        array_unshift($this->template_packs, $template_pack);
    }

    /**
     * Set messages class.
     *
     * @param string Class name of Renderer.
     */
    public function setMessages(string $messages_class)
    {
        $this->messages_class = $messages_class;
    }

    /**
     * Get messages class.
     *
     * @param Messages Messages class.
     */
    public function getMessages()
    {
        return $this->messages_class;
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
