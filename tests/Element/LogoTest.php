<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Atom;
use Mekras\Atom\Element\Logo;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Logo
 *
 * @covers Mekras\Atom\Element\Logo
 */
class LogoTest extends TestCase
{
    /**
     * Test element import.
     */
    public function testParse()
    {
        $element = $this->createDomElement('logo', Atom::NS, 'http://example.com/logo.png');

        $link = new Logo($this->createFakeNode(), $element);
        static::assertEquals('http://example.com/logo.png', $link->getUri());
        static::assertEquals('http://example.com/logo.png', (string) $link);
    }

    /**
     * Test creating new element.
     */
    public function testCreate()
    {
        /** @var Logo $element */
        $element = $this->createElement('atom:logo');
        static::assertInstanceOf(Logo::class, $element);

        $element->setUri('http://example.com/logo.png');

        static::assertEquals('<logo>http://example.com/logo.png</logo>', $this->getXML($element));
    }
}
