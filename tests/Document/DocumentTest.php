<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Document;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Extensions;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Document\Document
 *
 * @covers Mekras\Atom\Document\Document
 */
class DocumentTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unexpected node "foo", expecting "bar"
     */
    public function testInvalidRootTag()
    {
        $doc = $this->createDocument('', 'foo');

        $document = $this->getMockBuilder(Document::class)->setMethods(['getRootNodeName'])
            ->disableOriginalConstructor()->getMock();
        $document->expects(static::any())->method('getRootNodeName')->willReturn('bar');
        /** @var Document $document */
        $document->__construct(new Extensions(), $doc);
    }
}
