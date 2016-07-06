<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Extension\DocumentExtension;

/**
 * Tests for Mekras\Atom\DocumentFactory
 *
 * @covers Mekras\Atom\DocumentFactory
 */
class DocumentFactoryTest extends TestCase
{
    /**
     * Parse Feed
     */
    public function testParseFeed()
    {
        $factory = new DocumentFactory();
        $doc = $factory->parseXML(file_get_contents(__DIR__ . '/fixtures/FeedDocument.xml'));
        static::assertInstanceOf(FeedDocument::class, $doc);
    }

    /**
     * Parse Entry
     */
    public function testParseEntry()
    {
        $factory = new DocumentFactory();
        $doc = $factory->parseXML(file_get_contents(__DIR__ . '/fixtures/EntryDocument.xml'));
        static::assertInstanceOf(EntryDocument::class, $doc);
    }

    /**
     * Create new entry document.
     */
    public function testCreateEntry()
    {
        $factory = new DocumentFactory();
        $doc = $factory->createDocument(EntryDocument::class);
        static::assertInstanceOf(EntryDocument::class, $doc);
    }

    /**
     * Test extensions.
     */
    public function testExtensions()
    {
        $factory = new DocumentFactory();

        $extension = $this->getMockForAbstractClass(DocumentExtension::class);
        $doc1 = new \stdClass();
        $extension->expects(static::once())->method('parseDocument')->willReturn($doc1);
        /** @var DocumentExtension $extension */
        $factory->getExtensions()->register($extension);

        $doc2 = $factory->parseDocument($this->loadFixture('FeedDocument.xml'));
        static::assertSame($doc1, $doc2);
    }
}
