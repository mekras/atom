<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Extensions;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Element
 */
class ElementTest extends TestCase
{
    /**
     *
     */
    public function testBasics()
    {
        $element = $this->getMockBuilder(Element::class)->disableOriginalConstructor()
            ->setMethods(['getNodeName'])->getMock();
        $element->expects(static::any())->method('getNodeName')->willReturn('foo');
        /** @var Element $element */

        $parent = $this->createFakeNode();
        $element->__construct($parent);

        static::assertSame($parent, $element->getParent());
        static::assertInstanceOf(Extensions::class, $element->getExtensions());
    }
}
