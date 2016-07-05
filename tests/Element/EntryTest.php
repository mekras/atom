<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Construct\Text;
use Mekras\Atom\Element\Content;
use Mekras\Atom\Element\Entry;

/**
 * Tests for Mekras\Atom\Element\Entry
 */
class EntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test importing valid entry
     */
    public function testImport()
    {
        $doc = new \DOMDocument();
        $doc->load(__DIR__ . '/../fixtures/EntryDocument.xml');

        $entry = new Entry($doc->documentElement);
        static::assertEquals('Author 1, Author 2', implode(', ', $entry->getAuthors()));
        static::assertEquals('urn:foo:atom1:entry:0001', $entry->getId());
        static::assertEquals('http://example.com/atom/atom/?id=0001', $entry->getSelfLink());
        $value = $entry->getTitle();
        static::assertInstanceOf(Text::class, $value);
        static::assertEquals('text', $value->getType());
        static::assertEquals('Entry 1 Title', (string) $value);
        static::assertEquals('2016-01-23 11:22:33', $entry->getUpdated()->format('Y-m-d H:i:s'));

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
