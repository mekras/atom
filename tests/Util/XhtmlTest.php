<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Util;

use Mekras\Atom\Atom;
use Mekras\Atom\Util\Xhtml;

/**
 * Tests for Mekras\Atom\Util\Xhtml
 */
class XhtmlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test extracting HTML.
     */
    public function testExtract()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<text xmlns="http://www.w3.org/2005/Atom" type="xhtml" ' .
            'xmlns:xhtml="http://www.w3.org/1999/xhtml">&lt;em>' .
            '<xhtml:div><xhtml:em> &lt; </xhtml:em></xhtml:div>' .
            '</text>'
        );

        /** @var \DOMElement $element */
        $element = $doc->documentElement->getElementsByTagNameNS(Atom::XHTML, 'div')->item(0);
        static::assertEquals('<em> &lt; </em>', Xhtml::extract($element));
    }
}
