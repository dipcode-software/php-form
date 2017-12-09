<?php
namespace PHPForm\Unit\Renderers;

use PHPUnit\Framework\TestCase;
use Twig_TemplateWrapper;

use PHPForm\Renderers\TwigRenderer;

class TwigRendererTest extends TestCase
{
    public function setUp()
    {
        $this->renderer = new TwigRenderer(__DIR__ . "/templates");
    }

    public function testGetTempate()
    {
        $result = $this->renderer->getTemplate("dummy.html");
        $this->assertInstanceOf(Twig_TemplateWrapper::class, $result);
    }

    public function testRender()
    {
        $expected = "Dummy template test\n";
        $result = $this->renderer->render("dummy.html", array("name" => "test"));
        $this->assertEquals($expected, $result);
    }
}
