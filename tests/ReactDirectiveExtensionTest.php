<?php
use TwigReactDirective\ReactDirectiveExtension;

class AssetObject extends PHPUnit_Framework_TestCase {
    // dirty hack
    public function testAssetTwigExtension() {  }
}

class ReactDirectiveExtensionTest extends Twig_Test_IntegrationTestCase
{
    public $test;

    public function getExtensions()
    {
        $extension = new ReactDirectiveExtension();
        return array(new Twig_Extension_Debug(), $extension);
    }

    public function setUp()
    {
        $this->test = new AssetObject;
        $this->test->setUp();
    }

    public function tearDown()
    {
        $this->test->tearDown();
    }

    public function getFixturesDir()
    {
        return dirname(__FILE__) . '/Fixtures/';
    }
}

