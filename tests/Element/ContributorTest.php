<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Element;

use Mekras\Atom\Element\Contributor;
use Mekras\Atom\Tests\TestCase;

/**
 * Tests for Mekras\Atom\Element\Contributor
 */
class ContributorTest extends TestCase
{
    /**
     *
     */
    public function testBasics()
    {
        $doc = $this->createDocument(
            '<name>Foo</name><email> foo@example.com</email><uri>http://example.com/ </uri>'
        );

        $contributor = new Contributor($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('Foo', $contributor->getName());
        static::assertEquals('Foo', (string) $contributor);
        static::assertEquals('foo@example.com', $contributor->getEmail());
        static::assertEquals('http://example.com/', $contributor->getUri());
    }

    /**
     * __toString should return an empty string in case of error.
     */
    public function testRenderError()
    {
        $doc = $this->createDocument();
        $contributor = new Contributor($this->createFakeNode(), $doc->documentElement);
        static::assertEquals('', (string) $contributor);
    }
}
