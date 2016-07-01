<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Content;

/**
 * Tests for Mekras\Atom\Element\Content
 *
 * @covers Mekras\Atom\Element\Content
 * @covers Mekras\Atom\Element\Element
 * @covers Mekras\Atom\Node
 */
class ContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test "text" type
     */
    public function testText()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<doc xmlns="http://www.w3.org/2005/Atom">' .
            '<content>Less: &lt;</content>' .
            '</doc>'
        );

        $content = new Content($doc->documentElement->firstChild);
        static::assertEquals('text', $content->getType());
        static::assertEquals('Less: <', (string) $content);
    }

    /**
     * Test "html" type
     */
    public function testHtml()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<doc xmlns="http://www.w3.org/2005/Atom">' .
            '<content type="html">&lt;em> &amp;lt; &lt;/em></content>' .
            '</doc>'
        );

        $content = new Content($doc->documentElement->firstChild);
        static::assertEquals('html', $content->getType());
        static::assertEquals('<em> &lt; </em>', (string) $content);
    }

    /**
     * Test "xhtml" type
     */
    public function testXhtml()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<doc xmlns="http://www.w3.org/2005/Atom" xmlns:xhtml="http://www.w3.org/1999/xhtml">' .
            '<content type="xhtml">' .
            '<xhtml:div><xhtml:em> &lt; </xhtml:em></xhtml:div>' .
            '</content>' .
            '</doc>'
        );

        $content = new Content($doc->documentElement->firstChild);
        static::assertEquals('xhtml', $content->getType());
        static::assertEquals('<em> &lt; </em>', (string) $content);
    }

    /**
     * Test "image/svg+xml" type
     */
    public function testSvg()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<doc xmlns="http://www.w3.org/2005/Atom" xmlns:xhtml="http://www.w3.org/1999/xhtml">' .
            '<content type="image/svg+xml">' .
            '<svg xmlns="http://www.w3.org/2000/svg"><circle r="20"/></svg>' .
            '</content>' .
            '</doc>'
        );

        $content = new Content($doc->documentElement->firstChild);
        static::assertEquals('image/svg+xml', $content->getType());
        static::assertEquals(
            '<svg xmlns="http://www.w3.org/2000/svg"><circle r="20"/></svg>',
            (string) $content
        );
    }

    /**
     * Test "text/foo" type
     */
    public function testTextFoo()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<doc xmlns="http://www.w3.org/2005/Atom" xmlns:xhtml="http://www.w3.org/1999/xhtml">' .
            '<content type="text/foo">Foo</content>' .
            '</doc>'
        );

        $content = new Content($doc->documentElement->firstChild);
        static::assertEquals('text/foo', $content->getType());
        static::assertEquals('Foo', (string) $content);
    }

    /**
     * Test base64
     */
    public function testBase64()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<doc xmlns="http://www.w3.org/2005/Atom" xmlns:xhtml="http://www.w3.org/1999/xhtml">' .
            '<content type="foo/bar">Rm9v</content>' .
            '</doc>'
        );

        $content = new Content($doc->documentElement->firstChild);
        static::assertEquals('foo/bar', $content->getType());
        static::assertEquals('Foo', (string) $content);
    }
}
