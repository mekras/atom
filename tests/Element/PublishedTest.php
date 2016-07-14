<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Atom;
use Mekras\Atom\Element\Published;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Published
 */
class PublishedTest extends TestCase
{
    /**
     * Test basic functionality.
     */
    public function testBasics()
    {
        $element = $this->createDomElement('published', Atom::NS, '2016-01-23T11:22:33Z');

        $published = new Published($this->createFakeNode(), $element);
        static::assertEquals('2016-01-23 11:22:33', $published->getDate()->format('Y-m-d H:i:s'));
        static::assertEquals('2016-01-23T11:22:33Z', (string) $published);
    }
}
