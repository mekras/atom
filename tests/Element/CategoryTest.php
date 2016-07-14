<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Atom;
use Mekras\Atom\Element\Category;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Category
 *
 * @covers Mekras\Atom\Element\Category
 */
class CategoryTest extends TestCase
{
    /**
     * Test basic functionality.
     */
    public function testBasics()
    {
        $element = $this->createDomElement('category', Atom::NS);
        $element->setAttribute('term', 'foo');
        $element->setAttribute('label', 'Foo');
        $element->setAttribute('scheme', 'http://example.com/');

        $category = new Category($this->createFakeNode(), $element);
        static::assertEquals('foo', $category->getTerm());
        static::assertEquals('foo', (string) $category);
        static::assertEquals('Foo', $category->getLabel());
        static::assertEquals('http://example.com/', $category->getScheme());
    }

    /**
     * __toString should not fail in case of error.
     */
    public function testRenderError()
    {
        $element = $this->createDomElement('category', Atom::NS);
        $category = new Category($this->createFakeNode(), $element);
        static::assertEquals('(empty category)', (string) $category);
    }
}
