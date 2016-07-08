<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Document;

use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Element\Entry;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Document\EntryDocument
 */
class EntryDocumentTest extends TestCase
{
    /**
     * Test importing valid entry
     */
    public function testImport()
    {
        $doc = $this->loadFixture('EntryDocument.xml');

        $document = new EntryDocument($this->createExtensions(), $doc);
        $entry = $document->getEntry();
        static::assertInstanceOf(Entry::class, $entry);
    }

    /**
     * Test creating new entry
     */
    public function testCreate()
    {
        $document = new EntryDocument($this->createExtensions());
        $entry = $document->getEntry();
        $entry->setId('urn:foo:entry:0001');
        $entry->setTitle('Entry Title');
        $entry->addAuthor('Author 1')->setEmail('foo@example.com');
        $entry->addAuthor('Author 2')->setUri('http://example.com/');
        $entry->addContributor('Author 3');
        $entry->getContent()->setContent('<h1>Entry content</h1>', 'html');
        $entry->addCategory('tag1')->setScheme('http://example.com/scheme');
        $entry->addCategory('tag2')->setLabel('TAG 2');

        $document->getDomDocument()->formatOutput = true;
        static::assertEquals(
            file_get_contents($this->locateFixture('EntryDocument.txt')),
            (string) $document
        );
    }
}
