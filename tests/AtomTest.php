<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Atom;
use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\Extension\DocumentType;

/**
 * Tests for Mekras\Atom\Atom
 *
 * @covers Mekras\Atom\Atom
 */
class AtomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Parse Feed
     */
    public function testParseFeed()
    {
        $atom = new Atom();
        $doc = $atom->parseXML(file_get_contents(__DIR__ . '/fixtures/FeedDocument.xml'));
        static::assertInstanceOf(FeedDocument::class, $doc);
    }

    /**
     * Parse Entry
     */
    public function testParseEntry()
    {
        $atom = new Atom();
        $doc = $atom->parseXML(file_get_contents(__DIR__ . '/fixtures/EntryDocument.xml'));
        static::assertInstanceOf(EntryDocument::class, $doc);
    }

    /**
     * Test extensions.
     */
    public function testExtensions()
    {
        $atom = new Atom();

        $extension = $this->getMockForAbstractClass(DocumentType::class);
        $doc1 = new \stdClass();
        $extension->expects(static::once())->method('createDocument')
            ->willReturnCallback(
                function (\DOMDocument $document) use ($doc1) {
                    static::assertEquals('foo', $document->documentElement->localName);

                    return $doc1;
                }
            );
        /** @var DocumentType $extension */
        $atom->registerDocumentType($extension);

        $doc2 = $atom->parseXML(file_get_contents(__DIR__ . '/fixtures/FooDocument.xml'));
        static::assertSame($doc1, $doc2);
    }
}
