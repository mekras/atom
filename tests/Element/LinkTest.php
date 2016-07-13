<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Atom;
use Mekras\Atom\Element\Link;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Link
 */
class LinkTest extends TestCase
{
    /**
     *
     */
    public function testBasics()
    {
        $element = $this->createDomElement('link', Atom::NS);
        $element->setAttribute('href', 'http://example.com/');
        $element->setAttribute('type', 'text/html');
        $element->setAttribute('hreflang', 'ru');
        $element->setAttribute('title', 'Foo');
        $element->setAttribute('length', '1024');

        $link = new Link($this->createFakeNode(), $element);
        static::assertEquals('http://example.com/', $link->getUri());
        static::assertEquals('alternate', $link->getRelation());
        static::assertEquals('text/html', $link->getType());
        static::assertEquals('ru', $link->getLanguage());
        static::assertEquals('Foo', $link->getTitle());
        static::assertEquals(1024, $link->getLength());
    }

    /**
     * __toString should not fail in case of error.
     */
    public function testRenderError()
    {
        $element = $this->createDomElement('link', Atom::NS);
        $link = new Link($this->createFakeNode(), $element);
        static::assertEquals('(empty link)', (string) $link);
    }
}
