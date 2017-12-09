<?php
namespace PHPForm\Unit\TemplatePacks;

use PHPUnit\Framework\TestCase;

use PHPForm\TemplatePacks\DefaultTemplatePack;

class DefaultTemplatePackTest extends TestCase
{
    public function testConstants()
    {
        $this->assertEquals("default", DefaultTemplatePack::NAME);
        $this->assertContains("/TemplatePacks/templates/default/", DefaultTemplatePack::TEMPLATES_DIR);
    }
}
