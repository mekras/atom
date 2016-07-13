<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Title;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Content
 */
class TitleTest extends TestCase
{
    /**
     * Test "text" type
     */
    public function testText()
    {
        $doc = $this->createDomDocument('Less: &lt;');
        $title = new Title($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('text', $title->getType());
        static::assertEquals('Less: <', (string) $title);
    }

    /**
     * Test "html" type
     */
    public function testHtml()
    {
        $doc = $this->createDomDocument('<title type="html">&lt;em> &amp;lt; &lt;/em></title>');

        $title = new Title($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('html', $title->getType());
        static::assertEquals('<em> &lt; </em>', (string) $title);
    }

    /**
     * Test "xhtml" type
     */
    public function testXhtml()
    {
        $doc = $this->createDomDocument(
            '<title type="xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml">' .
            '<xhtml:div><xhtml:em> &lt; </xhtml:em></xhtml:div>' .
            '</title>'
        );

        $title = new Title($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('xhtml', $title->getType());
        static::assertEquals('<em> &lt; </em>', (string) $title);
    }

    /**
     * __toString should return an empty string in case of error.
     */
    public function testRenderError()
    {
        $doc = $this->createDomDocument(
            '<title type="xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml"></title>'
        );

        $title = new Title($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('', (string) $title);
    }

    /**
     * Test set/get
     */
    public function testSetGet()
    {
        $doc = $this->createDomDocument('foo');
        $title = new Title($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('foo', (string) $title);
        $title->setContent('bar');
        static::assertEquals('bar', (string) $title);
    }
}
