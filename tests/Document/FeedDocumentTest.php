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

/**
 * Tests for Mekras\Atom\Document\FeedDocument
 */
class FeedDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test importing valid feed
     */
    public function testImport()
    {
        $doc = new \DOMDocument();
        $doc->load(__DIR__ . '/../fixtures/FeedDocument.xml');

        $document = new FeedDocument($doc);
        $feed = $document->getFeed();
        static::assertInstanceOf(Feed::class, $feed);
    }

    /**
     * Test creating new feed
     */
    public function testCreate()
    {
        $document = new FeedDocument();
        $feed = $document->getFeed();
        $feed->setId('urn:foo:feed:0001');
        $feed->setTitle('Feed Title');
        $feed->addAuthor('Feed Author')->setEmail('foo@example.com')->setUri('http://example.com/');
        $feed->addCategory('tag1')->setScheme('http://example.com/scheme')->setLabel('TAG 1');

        $entry = $feed->addEntry();
        $entry->setId('urn:foo:entry:0001');
        $entry->setTitle('Entry Title');

        $document->getDomDocument()->formatOutput = true;
        static::assertEquals(
            file_get_contents(__DIR__ . '/../fixtures/FeedDocument.txt'),
            (string) $document
        );
    }
}
