<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Atom;
use Mekras\Atom\Node;

/**
 * Tests for Mekras\Atom\Node
 */
class NodeTest extends TestCase
{
    /**
     *
     */
    public function testBasics()
    {
        $document = $this->createDocument();
        $parent = $this->createFakeNode();
        /** @var Node $node */
        $node = $this->getMockForAbstractClass(Node::class, [$document->documentElement, $parent]);

        static::assertSame($document->documentElement, $node->getDomElement());
        static::assertSame($parent, $node->getParent());
        static::assertSame(Atom::NS, $node->ns());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unexpected NS "http://example.org"
     */
    public function testInvalidNS()
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadXML('<doc xmlns="http://example.org"/>');
        $parent = $this->createFakeNode();
        $this->getMockForAbstractClass(Node::class, [$document->documentElement, $parent]);
    }

    /**
     *
     */
    public function testQueryMultiple()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $nodes = $node->query('atom:a');
        static::assertEquals(2, $nodes->length);
    }

    /**
     *
     */
    public function testQueryMultipleNone()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $nodes = $node->query('atom:c');
        static::assertEquals(0, $nodes->length);
    }

    /**
     * @expectedException \Mekras\Atom\Exception\MalformedNodeException
     */
    public function testQueryMultipleRequired()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $node->query('atom:c', Node::REQUIRED);
    }

    /**
     *
     */
    public function testQuerySingle()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $element = $node->query('atom:b', Node::SINGLE);
        static::assertInstanceOf(\DOMElement::class, $element);
    }

    /**
     *
     */
    public function testQuerySingleNone()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $element = $node->query('atom:c', Node::SINGLE);
        static::assertNull($element);
    }

    /**
     * @expectedException \Mekras\Atom\Exception\MalformedNodeException
     */
    public function testQuerySingleMultiple()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $element = $node->query('atom:a', Node::SINGLE);
        static::assertNull($element);
    }

    /**
     * @expectedException \Mekras\Atom\Exception\MalformedNodeException
     */
    public function testQuerySingleRequired()
    {
        $document = $this->createDocument('<a/><b/><a/>');
        $node = $this->createInstance($document);
        $node->query('atom:c', Node::SINGLE | Node::REQUIRED);
    }

    /**
     *
     */
    public function testGetAttribute()
    {
        $document = $this->createDocument('<foo bar="baz"/>');
        $parent = $this->createFakeNode($document);
        $node = $this->getMockForAbstractClass(
            Node::class,
            [$document->documentElement->firstChild, $parent]
        );
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());
        /** @var Node $node */

        static::assertEquals('baz', $node->getAttribute('atom:bar'));
        static::assertNull($node->getAttribute('atom:foo'));
    }

    /**
     *
     */
    public function testGetAttributeCustomPrefix()
    {
        $document = $this->createDocument('<a:foo a:bar="baz"/>', 'a:doc');
        $parent = $this->createFakeNode($document);
        $node = $this->getMockForAbstractClass(
            Node::class,
            [$document->documentElement->firstChild, $parent]
        );
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());
        /** @var Node $node */

        static::assertEquals('baz', $node->getAttribute('atom:bar'));
        static::assertNull($node->getAttribute('atom:foo'));
    }

    /**
     *
     */
    public function testSetAttribute()
    {
        $document = $this->createDocument();
        $node = $this->createInstance($document);
        $node->setAttribute('atom:bar', 'baz');
        static::assertEquals(
            '<doc xmlns="http://www.w3.org/2005/Atom" xmlns:xhtml="http://www.w3.org/1999/xhtml" ' .
            'bar="baz"/>',
            $this->getXML($node)
        );
    }

    /**
     *
     */
    public function testSetAttributeCustomPrefix()
    {
        $document = $this->createDocument('', 'a:doc');
        $node = $this->createInstance($document);
        $node->setAttribute('atom:bar', 'baz');
        static::assertEquals(
            '<a:doc xmlns:a="http://www.w3.org/2005/Atom" ' .
            'xmlns:xhtml="http://www.w3.org/1999/xhtml" a:bar="baz"/>',
            $this->getXML($node)
        );
    }

    /**
     * Create new test Node instance.
     *
     * @param \DOMDocument $document
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Node
     */
    private function createInstance($document)
    {
        $parent = $this->createFakeNode($document);
        $node = $this->getMockForAbstractClass(Node::class, [$document->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        return $node;
    }
}
