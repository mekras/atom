<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Document;

use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\Element\Feed;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Document\FeedDocument
 */
class FeedDocumentTest extends TestCase
{
    /**
     * Test importing valid feed
     */
    public function testImport()
    {
        $doc = $this->loadFixture('FeedDocument.xml');

        $document = new FeedDocument($this->createExtensions(), $doc);
        $feed = $document->getFeed();
        static::assertInstanceOf(Feed::class, $feed);
    }

    /**
     * Test creating new feed
     */
    public function testCreate()
    {
        $document = new FeedDocument($this->createExtensions());
        $feed = $document->getFeed();
        $feed->addId('urn:foo:feed:0001');
        $feed->addTitle('Feed Title');
        $feed->addAuthor('Feed Author')->setEmail('foo@example.com')->setUri('http://example.com/');
        $feed->addCategory('tag1')->setScheme('http://example.com/scheme')->setLabel('TAG 1');
        $feed->addIcon('http://example.com/feed.png');
        $feed->addGenerator('Generator')->setUri('http://example.com/generator')->setVersion('1.0');

        $entry = $feed->addEntry();
        $entry->addId('urn:foo:entry:0001');
        $entry->addTitle('Entry Title');

        $document->getDomDocument()->formatOutput = true;
        static::assertEquals(
            file_get_contents($this->locateFixture('FeedDocument.txt')),
            (string) $document
        );
    }
}
