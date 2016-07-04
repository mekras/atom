<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Element
 *
 * @covers Mekras\Atom\Element\Element
 */
class ElementTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unexpected element name "foo", expecting "bar"
     */
    public function testInvalidRootTag()
    {
        $doc = $this->createDocument('', 'foo');

        $element = $this->getMockBuilder(Element::class)->setMethods(['getNodeName'])
            ->disableOriginalConstructor()->getMock();
        $element->expects(static::any())->method('getNodeName')->willReturn('bar');
        /** @var Element $element */
        $element->__construct($doc->documentElement);
    }
}
