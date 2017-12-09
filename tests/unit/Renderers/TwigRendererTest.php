<?php
namespace PHPForm\Unit\Renderers;

use PHPUnit\Framework\TestCase;
use Twig_TemplateWrapper;

use PHPForm\Renderers\TwigRenderer;

class TwigRendererTest extends TestCase
{
    public function setUp()
    {
        $this->renderer = new TwigRenderer(__DIR__ . "/templates/pack1", __DIR__ . "/templates/pack2");
    }

    public function testGetTempate()
    {
        $result = $this->renderer->getTemplate("template.html");
        $this->assertInstanceOf(Twig_TemplateWrapper::class, $result);
    }

    public function testRender()
    {
        $result = $this->renderer->render("template.html", array("name" => "test"));
        $expected = "Pack2 template test";

        $this->assertEquals($expected, $result);
    }

    public function testRenderFallback()
    {
        $result = $this->renderer->render("template2.html", array("name" => "test"));
        $expected = "Pack1 template2 test";

        $this->assertEquals($expected, $result);
    }

    public function testRenderWithOnlyFallbackDefined()
    {
        $renderer = new TwigRenderer(__DIR__ . "/templates/pack1");

        $result = $renderer->render("template.html", array("name" => "test"));
        $expected = "Pack1 template test";

        $this->assertEquals($expected, $result);
    }
}
