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

/**
 * Tests for Mekras\Atom\Document\EntryDocument
 *
 * @covers Mekras\Atom\Document\EntryDocument
 * @covers Mekras\Atom\Document\Document
 * @covers Mekras\Atom\Node
 */
class EntryDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test importing valid feed
     */
    public function testImport()
    {
        $doc = new \DOMDocument();
        $doc->load(__DIR__ . '/../fixtures/EntryDocument.xml');

        $document = new EntryDocument($doc);
        $entry = $document->getEntry();
        static::assertInstanceOf(Entry::class, $entry);
    }
}
