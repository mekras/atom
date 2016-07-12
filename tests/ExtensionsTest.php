<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Extension\DocumentExtension;
use Mekras\Atom\Extension\ElementExtension;
use Mekras\Atom\Extension\Extension;
use Mekras\Atom\Extensions;

/**
 * Tests for Mekras\Atom\Extensions
 */
class ExtensionsTest extends TestCase
{
    /**
     * Test document parsing.
     */
    public function testParseDocument()
    {
        $extensions = new Extensions();

        $extension = $this->getMockForAbstractClass(DocumentExtension::class);
        $doc1 = new \stdClass();
        $extension->expects(static::exactly(2))->method('parseDocument')
            ->willReturnCallback(
                function ($extensions, \DOMDocument $document) use ($doc1) {
                    return 'feed' === $document->documentElement->localName ? $doc1 : null;
                }
            );
        /** @var Extension $extension */
        $extensions->register($extension);

        $doc2 = $extensions->parseDocument($this->loadXML('FeedDocument.xml'));
        static::assertSame($doc1, $doc2);
        static::assertNull($extensions->parseDocument($this->loadXML('EntryDocument.xml')));
    }

    /**
     * Test element parsing.
     */
    public function testParseElement()
    {
        $extensions = new Extensions();

        $extension = $this->getMockForAbstractClass(ElementExtension::class);
        $node1 = new \stdClass();
        $extension->expects(static::exactly(2))->method('parseElement')
            ->willReturnCallback(
                function ($extensions, \DOMElement $element) use ($node1) {
                    return 'feed' === $element->localName ? $node1 : null;
                }
            );
        /** @var Extension $extension */
        $extensions->register($extension);
        $parent = $this->createFakeNode();

        $node2 = $extensions->parseElement(
            $parent,
            $this->loadXML('FeedDocument.xml')->documentElement
        );
        static::assertSame($node1, $node2);
        static::assertNull(
            $extensions->parseElement(
                $parent,
                $this->loadXML('EntryDocument.xml')->documentElement
            )
        );
    }
}
