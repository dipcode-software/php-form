<?php
namespace PHPForm\Unit\Renderers;

use PHPUnit\Framework\TestCase;
use Twig_TemplateWrapper;

use PHPForm\Renderers\TwigRenderer;

class TwigRendererTest extends TestCase
{
    public function setUp()
    {
        $this->renderer = new TwigRenderer([__DIR__ . "/templates/pack2", __DIR__ . "/templates/pack1"]);
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
        $renderer = new TwigRenderer([__DIR__ . "/templates/pack1"]);

        $result = $renderer->render("template.html", array("name" => "test"));
        $expected = "Pack1 template test";

        $this->assertEquals($expected, $result);
    }

    public function testFilterRenderStr()
    {
        $renderer = new TwigRenderer([__DIR__ . "/templates/pack1"]);

        $result = $renderer->render("merge_str_filter.html", array("attrs" => ["class" => "existent"]));
        $expected = "class merged existent";

        $this->assertEquals($expected, $result);
    }

    public function testFilterRenderStrWithoutArg()
    {
        $renderer = new TwigRenderer([__DIR__ . "/templates/pack1"]);

        $result = $renderer->render("merge_str_filter.html", array("attrs" => []));
        $expected = "class merged";

        $this->assertEquals($expected, $result);
    }
}
