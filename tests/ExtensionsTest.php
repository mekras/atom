<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Extension\Extension;
use Mekras\Atom\Extensions;

/**
 * Tests for Mekras\Atom\Extensions
 *
 * @covers Mekras\Atom\Extensions
 */
class ExtensionsTest extends TestCase
{
    /**
     * Basics tests.
     */
    public function testBasics()
    {
        $extensions = new Extensions();

        $extension = $this->getMockForAbstractClass(Extension::class);
        $doc1 = new \stdClass();
        $extension->expects(static::exactly(2))->method('parseDocument')
            ->willReturnCallback(
                function ($extensions, \DOMDocument $document) use ($doc1) {
                    return 'feed' === $document->documentElement->localName ? $doc1 : null;
                }
            );
        /** @var Extension $extension */
        $extensions->register($extension);

        $doc2 = $extensions->parseDocument($this->loadFixture('FeedDocument.xml'));
        static::assertSame($doc1, $doc2);
        static::assertNull($extensions->parseDocument($this->loadFixture('EntryDocument.xml')));
    }
}
