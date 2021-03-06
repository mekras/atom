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
 */
class DocumentFactoryTest extends TestCase
{
    /**
     * Parse Feed
     */
    public function testParseFeed()
    {
        $factory = new DocumentFactory();
        $doc = $factory->parseXML(file_get_contents($this->locateFixture('FeedDocument.xml')));
        static::assertInstanceOf(FeedDocument::class, $doc);
    }

    /**
     * Create new feed document.
     */
    public function testCreateFeed()
    {
        $factory = new DocumentFactory();
        $doc = $factory->createDocument('atom:feed');
        static::assertInstanceOf(FeedDocument::class, $doc);
    }

    /**
     * Parse Entry
     */
    public function testParseEntry()
    {
        $factory = new DocumentFactory();
        $doc = $factory->parseXML(file_get_contents($this->locateFixture('EntryDocument.xml')));
        static::assertInstanceOf(EntryDocument::class, $doc);
    }

    /**
     * Create new entry document.
     */
    public function testCreateEntry()
    {
        $factory = new DocumentFactory();
        $doc = $factory->createDocument('atom:entry');
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

        $doc2 = $factory->parseDocument($this->loadXML('FeedDocument.xml'));
        static::assertSame($doc1, $doc2);
    }

    /**
     * Test invalid XML.
     *
     * @expectedException \Mekras\Atom\Exception\RuntimeException
     * @expectedExceptionMessage Can not parse XML
     */
    public function testInvalidXML()
    {
        $factory = new DocumentFactory();
        $factory->parseXML('foo');
    }

    /**
     * Test create invalid document.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unknown document "foo"
     */
    public function testCreateInvalidDocument()
    {
        $factory = new DocumentFactory();
        $factory->createDocument('foo');
    }

    /**
     * Test parse invalid document.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unexpected root element "doc"
     */
    public function testParseInvalidDocument()
    {
        $factory = new DocumentFactory();
        $document = $this->createDomDocument();
        $factory->parseDocument($document);
    }
}
