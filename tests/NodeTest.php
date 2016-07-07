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
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"/>');
        $parent = $this->createFakeNode();
        /** @var Node $node */
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);

        static::assertSame($doc->documentElement, $node->getDomElement());
        static::assertSame($parent, $node->getParent());
        static::assertSame(Atom::NS, $node->ns());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unexpected NS "http://example.org"
     */
    public function testInvalidNS()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="http://example.org"/>');
        $parent = $this->createFakeNode();
        $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
    }

    /**
     *
     */
    public function testQueryMultiple()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        /** @var \DOMNodeList $nodes */
        $nodes = $query->invoke($node, 'atom:a');
        static::assertEquals(2, $nodes->length);
    }

    /**
     *
     */
    public function testQueryMultipleNone()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        /** @var \DOMNodeList $nodes */
        $nodes = $query->invoke($node, 'atom:c');
        static::assertEquals(0, $nodes->length);
    }

    /**
     * @expectedException \Mekras\Atom\Exception\MalformedNodeException
     */
    public function testQueryMultipleRequired()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        $query->invoke($node, 'atom:c', Node::REQUIRED);
    }

    /**
     *
     */
    public function testQuerySingle()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        $element = $query->invoke($node, 'atom:b', Node::SINGLE);
        static::assertInstanceOf(\DOMElement::class, $element);
    }

    /**
     *
     */
    public function testQuerySingleNone()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        $element = $query->invoke($node, 'atom:c', Node::SINGLE);
        static::assertNull($element);
    }

    /**
     * @expectedException \Mekras\Atom\Exception\MalformedNodeException
     */
    public function testQuerySingleMultiple()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        $element = $query->invoke($node, 'atom:a', Node::SINGLE);
        static::assertNull($element);
    }

    /**
     * @expectedException \Mekras\Atom\Exception\MalformedNodeException
     */
    public function testQuerySingleRequired()
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML('<doc xmlns="' . Atom::NS . '"><a/><b/><a/></doc>');
        $parent = $this->createFakeNode();
        $node = $this->getMockForAbstractClass(Node::class, [$doc->documentElement, $parent]);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($parent->getExtensions());

        $query = new \ReflectionMethod(Node::class, 'query');
        $query->setAccessible(true);

        $query->invoke($node, 'atom:c', Node::SINGLE | Node::REQUIRED);
    }
}
