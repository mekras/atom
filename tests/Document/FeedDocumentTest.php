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
        $doc = $this->loadXML('FeedDocument.xml');

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
        $feed->addAuthor('Feed Author')
            ->setEmail('foo@example.com')
            ->setUri('http://example.com/foo');
        $feed->addCategory('tag1')
            ->setScheme('http://example.com/scheme')
            ->setLabel('TAG 1');
        $feed->addContributor('Contributor')
            ->setEmail('bar@example.com')
            ->setUri('http://example.com/bar');
        $feed->addGenerator('Generator')
            ->setUri('http://example.com/generator')
            ->setVersion('1.0');
        $feed->addIcon('http://example.com/feed-icon.png');
        $feed->addId('urn:feed:1');
        $feed->addLink('http://example.com/feed', 'self');
        $feed->addLink('http://example.com/feed/')->setType('text/html');
        $feed->addLogo('http://example.com/feed-logo.png');
        $feed->addRights('© Copyright by Foo');
        $feed->addSubtitle('Sub title');
        $feed->addTitle('Feed Title');
        $feed->addUpdated(new \DateTime('2003-12-13 18:30:03', new \DateTimeZone('+1:00')));

        for ($i = 3; $i > 0; $i--) {
            $entry = $feed->addEntry();
            $entry->addId('urn:entry:' . $i);
            $entry->addLink('http://example.com/' . $i . '.html')->setType('text/html');
            $entry->addTitle('Entry ' . $i);
            $entry->addUpdated(
                new \DateTime('2003-12-13 18:30:0' . $i, new \DateTimeZone('+1:00'))
            );
            $entry->getContent()->setContent('Entry ' . $i . ' text');
        }
        $document->getDomDocument()->formatOutput = true;
        static::assertEquals(
            file_get_contents($this->locateFixture('FeedDocument.txt')),
            (string) $document
        );
    }
}
