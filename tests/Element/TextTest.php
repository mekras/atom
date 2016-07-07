<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Content;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Content
 */
class TextTest extends TestCase
{
    /**
     * Test "text" type
     */
    public function testText()
    {
        $doc = $this->createDocument('Less: &lt;');
        $text = new Content($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('text', $text->getType());
        static::assertEquals('Less: <', (string) $text);
    }

    /**
     * Test "html" type
     */
    public function testHtml()
    {
        $doc = $this->createDocument('<text type="html">&lt;em> &amp;lt; &lt;/em></text>');

        $text = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('html', $text->getType());
        static::assertEquals('<em> &lt; </em>', (string) $text);
    }

    /**
     * Test "xhtml" type
     */
    public function testXhtml()
    {
        $doc = $this->createDocument(
            '<text type="xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml">' .
            '<xhtml:div><xhtml:em> &lt; </xhtml:em></xhtml:div>' .
            '</text>'
        );

        $text = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('xhtml', $text->getType());
        static::assertEquals('<em> &lt; </em>', (string) $text);
    }

    /**
     * __toString should return an empty string in case of error.
     */
    public function testRenderError()
    {
        $doc = $this->createDocument(
            '<text type="xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml"></text>'
        );

        $person = new Content($this->createFakeNode(), $doc->documentElement->firstChild);
        static::assertEquals('', (string) $person);
    }
}
