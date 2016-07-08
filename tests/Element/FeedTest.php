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
use Mekras\Atom\Element\Generator;
use Mekras\Atom\Element\Title;
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
        $document = $this->loadFixture('FeedDocument.xml');

        $feed = new Feed($this->createFakeNode(), $document->documentElement);
        static::assertEquals('Author 1, Author 2', implode(', ', $feed->getAuthors()));
        static::assertEquals('urn:foo:atom1:feed:id', $feed->getId());
        static::assertEquals('http://example.com/atom/feed', $feed->getLink('self'));
        $value = $feed->getTitle();
        static::assertInstanceOf(Title::class, $value);
        static::assertEquals('text', $value->getType());
        static::assertEquals('Feed Title', $value);
        static::assertEquals('http://example.com/feed.png', (string) $feed->getIcon());

        $value = $feed->getGenerator();
        static::assertInstanceOf(Generator::class, $value);
        static::assertEquals('Generator', (string )$value);
        static::assertEquals('http://example.com/generator', $value->getUri());
        static::assertEquals('1.0', $value->getVersion());

        static::assertEquals('2016-01-23 11:22:33', $feed->getUpdated()->format('Y-m-d H:i:s'));
        $entries = $feed->getEntries();
        static::assertCount(3, $entries);
        static::assertInstanceOf(Entry::class, $entries[0]);
        static::assertEquals('Entry 3 Title', (string) $entries[0]->getTitle());
    }
}
