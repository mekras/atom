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
 *
 * @covers Mekras\Atom\Document\FeedDocument
 * @covers Mekras\Atom\Document\Document
 * @covers Mekras\Atom\Node
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
}
