<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Atom;
use Mekras\Atom\Element\Content;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Content
 */
class ContentTest extends TestCase
{
    /**
     * Test getting "text" type
     */
    public function testGetText()
    {
        $doc = $this->createDocument('<content>Less: &lt;</content>');
        $content = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('text', $content->getType());
        static::assertEquals('Less: <', (string) $content);
    }

    /**
     * Test setting "text" type
     */
    public function testSetText()
    {
        $document = $this->createDocument();
        $element = $document->createElementNS(Atom::NS, 'content');
        $document->documentElement->appendChild($element);
        $content = new Content($this->createFakeNode(), $element);
        $content->setValue('Less: <', 'text');
        static::assertEquals(
            '<content type="text">Less: &lt;</content>',
            $document->saveXML($element)
        );
    }

    /**
     * Test getting "html" type
     */
    public function testGetHtml()
    {
        $doc = $this->createDocument('<content type="html">&lt;em> &amp;lt; &lt;/em></content>');
        $content = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('html', $content->getType());
        static::assertEquals('<em> &lt; </em>', (string) $content);
    }

    /**
     * Test setting "html" type
     */
    public function testSetHtml()
    {
        $document = $this->createDocument();
        $element = $document->createElementNS(Atom::NS, 'content');
        $document->documentElement->appendChild($element);
        $content = new Content($this->createFakeNode(), $element);
        $content->setValue('<em> &lt; </em>', 'html');
        static::assertEquals(
            '<content type="html">&lt;em&gt; &lt; &lt;/em&gt;</content>',
            $document->saveXML($element)
        );
    }

    /**
     * Test getting "xhtml" type
     */
    public function testGetXhtml()
    {
        $doc = $this->createDocument(
            '<content type="xhtml"><xhtml:div><xhtml:em> &lt; </xhtml:em></xhtml:div></content>'
        );

        $content = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('xhtml', $content->getType());
        static::assertEquals('<em> &lt; </em>', (string) $content);
    }

    /**
     * Test setting "xhtml" type
     */
    public function testSetXhtml()
    {
        $document = $this->createDocument('<content/>');
        $content = new Content($this->createFakeNode(), $document->documentElement->firstChild);

        $xhtml = $this->createElement('foo');
        $element = $xhtml->ownerDocument->createElement('bar', 'BAR');
        $element->setAttribute('a', 'b');
        $xhtml->appendChild($element);
        $xhtml->appendChild($xhtml->ownerDocument->createElement('baz', 'BAZ'));

        $content->setValue($xhtml, 'xhtml');
        static::assertEquals(
            '<content type="xhtml">' .
            '<xhtml:div><xhtml:bar a="b">BAR</xhtml:bar><xhtml:baz>BAZ</xhtml:baz></xhtml:div>' .
            '</content>',
            $document->saveXML($document->documentElement->firstChild)
        );
    }

    /**
     * Test getting "image/svg+xml" type
     */
    public function testGetSvg()
    {
        $doc = $this->createDocument(
            '<content type="image/svg+xml">' .
            '<svg xmlns="http://www.w3.org/2000/svg"><circle r="20"/></svg>' .
            '</content>'
        );

        $content = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('image/svg+xml', $content->getType());
        static::assertEquals(
            '<svg xmlns="http://www.w3.org/2000/svg"><circle r="20"/></svg>',
            (string) $content
        );
    }

    /**
     * Test setting "svg+xml" type
     */
    public function testSetSvg()
    {
        $document = $this->createDocument();
        $element = $document->createElementNS(Atom::NS, 'content');
        $document->documentElement->appendChild($element);
        $content = new Content($this->createFakeNode(), $element);

        $svg = new \DOMDocument('1.0', 'utf-8');
        $svg->loadXML('<svg xmlns="http://www.w3.org/2000/svg"><circle r="20"/></svg>');

        $content->setValue($svg->documentElement, 'image/svg+xml');
        static::assertEquals(
            '<content type="image/svg+xml">' .
            '<svg xmlns="http://www.w3.org/2000/svg"><circle r="20"/></svg>' .
            '</content>',
            $document->saveXML($element)
        );
    }

    /**
     * Test getting "text/foo" type
     */
    public function testGetTextFoo()
    {
        $doc = $this->createDocument('<content type="text/foo">Foo</content>');

        $content = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('text/foo', $content->getType());
        static::assertEquals('Foo', (string) $content);
    }

    /**
     * Test setting "text/foo" type
     */
    public function testSetTextFoo()
    {
        $document = $this->createDocument();
        $element = $document->createElementNS(Atom::NS, 'content');
        $document->documentElement->appendChild($element);
        $content = new Content($this->createFakeNode(), $element);
        $content->setValue('Less: <', 'text/foo');
        static::assertEquals(
            '<content type="text/foo">Less: &lt;</content>',
            $document->saveXML($element)
        );
    }

    /**
     * Test getting binary
     */
    public function testGetBinary()
    {
        $doc = $this->createDocument('<content type="foo/bar">Rm9v</content>');
        $content = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('foo/bar', $content->getType());
        static::assertEquals('Foo', (string) $content);
    }

    /**
     * Test setting binary
     */
    public function testSetBinary()
    {
        $document = $this->createDocument();
        $element = $document->createElementNS(Atom::NS, 'content');
        $document->documentElement->appendChild($element);
        $content = new Content($this->createFakeNode(), $element);
        $content->setValue('Foo', 'foo/bar');
        static::assertEquals(
            '<content type="foo/bar">Rm9v</content>',
            $document->saveXML($element)
        );
    }
}
