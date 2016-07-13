<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Entry;
use Mekras\Atom\Element\Feed;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Feed
 */
class FeedTest extends TestCase
{
    /**
     * Test importing valid feed
     */
    public function testImport()
    {
        $document = $this->loadXML('FeedDocument.xml');

        $feed = new Feed($this->createFakeNode(), $document->documentElement);
        static::assertEquals('Author 1, Author 2', implode(', ', $feed->getAuthors()));
        static::assertEquals('urn:feed:1', (string) $feed->getId());
        static::assertEquals('http://example.com/atom/feed', $feed->getLink('self'));
        $value = $feed->getTitle();
        static::assertEquals('text', $value->getType());
        static::assertEquals('Feed Title', $value);
        static::assertEquals('http://example.com/feed-icon.png', (string) $feed->getIcon());
        static::assertEquals('http://example.com/feed-logo.png', (string) $feed->getLogo());

        $value = $feed->getGenerator();
        static::assertEquals('Generator', (string) $value);
        static::assertEquals('http://example.com/generator', $value->getUri());
        static::assertEquals('1.0', $value->getVersion());

        $value = $feed->getSubtitle();
        static::assertEquals('text', $value->getType());
        static::assertEquals('Feed Subtitle', (string) $value);

        static::assertEquals(
            '2016-01-23 11:22:33',
            $feed->getUpdated()->getDate()->format('Y-m-d H:i:s')
        );
        $entries = $feed->getEntries();
        static::assertCount(3, $entries);
        static::assertInstanceOf(Entry::class, $entries[0]);
        static::assertEquals('Entry 3 Title', (string) $entries[0]->getTitle());
    }
}
