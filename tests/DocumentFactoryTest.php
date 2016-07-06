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
use Mekras\Atom\Extension\DocumentType;
use Mekras\Atom\Extensions;

/**
 * Tests for Mekras\Atom\DocumentFactory
 *
 * @covers Mekras\Atom\DocumentFactory
 */
class DocumentFactoryTest extends \PHPUnit_Framework_TestCase
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
     * Test extensions.
     */
    public function testExtensions()
    {
        $factory = new DocumentFactory();
        static::assertInstanceOf(Extensions::class, $factory->getExtensions());
    }
}
