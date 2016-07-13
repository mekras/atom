<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Content;
use Mekras\Atom\Element\Entry;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Entry
 */
class EntryTest extends TestCase
{
    /**
     * Test importing valid entry
     */
    public function testImport()
    {
        $doc = $this->loadXML('EntryDocument.xml');

        $entry = new Entry($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('Author 1, Author 2', implode(', ', $entry->getAuthors()));
        static::assertEquals('Author 3', implode(', ', $entry->getContributors()));
        static::assertEquals('urn:foo:atom1:entry:0001', $entry->getId());

        static::assertCount(2, $entry->getLinks());
        static::assertEquals(
            'http://example.com/atom/atom/?id=0001',
            (string) $entry->getLink('self')
        );
        static::assertEquals('text/xml', $entry->getLink('self')->getType());
        $alternates = $entry->getLinks('alternate');
        static::assertCount(1, $alternates);
        static::assertEquals('http://example.com/0001.html', (string) $alternates[0]);
        static::assertNull($entry->getLink('foo'));

        static::assertEquals(
            '2016-01-23 11:22:33',
            $entry->getPublished()->getDate()->format('Y-m-d H:i:s')
        );
        $value = $entry->getRights();
        static::assertEquals('text', $value->getType());
        static::assertEquals('Copyright', (string) $value);
        $value = $entry->getSummary();
        static::assertEquals('text', $value->getType());
        static::assertEquals('Summary', (string) $value);
        $value = $entry->getTitle();
        static::assertEquals('text', $value->getType());
        static::assertEquals('Entry 1 Title', (string) $value);
        static::assertEquals(
            '2016-01-23 11:22:33',
            $entry->getUpdated()->getDate()->format('Y-m-d H:i:s')
        );

        $categories = $entry->getCategories();
        static::assertCount(2, $categories);
        static::assertEquals('tag1', $categories[0]->getTerm());
        static::assertEquals('http://example.com/scheme', $categories[0]->getScheme());
        static::assertNull($categories[0]->getLabel());
        static::assertEquals('tag2', $categories[1]->getTerm());
        static::assertNull($categories[1]->getScheme());
        static::assertEquals('TAG 2', $categories[1]->getLabel());

        $content = $entry->getContent();
        static::assertInstanceOf(Content::class, $content);
        static::assertEquals(
            '<div style="text-align:center">Entry content</div>',
            (string) $content
        );
    }
}
