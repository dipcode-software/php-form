<?php
namespace PHPForm\Unit\TemplatePacks;

use PHPUnit\Framework\TestCase;

use PHPForm\TemplatePacks\Bootstrap4TemplatePack;

class Bootstrap4TemplatePackTest extends TestCase
{
    public function testConstants()
    {
        $this->assertEquals("bootstrap4", Bootstrap4TemplatePack::NAME);
        $this->assertContains("/TemplatePacks/templates/bootstrap4/", Bootstrap4TemplatePack::TEMPLATES_DIR);
    }
}
