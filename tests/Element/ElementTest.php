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
    public function testInvalidNodeName()
    {
        $doc = $this->createDocument('', 'foo');

        $element = $this->getMockBuilder(Element::class)->setMethods(['getNodeName'])
            ->disableOriginalConstructor()->getMock();
        $element->expects(static::any())->method('getNodeName')->willReturn('bar');
        /** @var Element $element */
        $element->__construct($this->createExtensions(), $doc->documentElement);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 1st argument of Mekras\Atom\Element\Element::__construct should be an instance of DOMElement or Mekras\Atom\Node
     */
    public function testInvalidArgument()
    {
        $this->getMockForAbstractClass(Element::class, [$this->createExtensions(), 'foo']);
    }
}
